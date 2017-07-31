<?php
/**
 * @file
 * Support class for creating individual student reports
 **/
namespace EMMA5\Libraries;

use PhpOffice\PhpWord\PhpWord as PhpWord;
use EMMA5\Exam as Exam;
use EMMA5\User as User;
use EMMA5\Grade as Grade;
use Carbon;
use Storage;
use File;
use Response;
use Helper;

/**
 * Class ReportUserDoc
 *
 * @author msantana <marco.santana@gmail.com>
 */
class ReportUserDoc
{
    /**
     * Creates a MSWord document with the simple report for a single user
     *
     * @return worddoc
     */
    public function __construct(Exam $exam, User $user)
    {
        $this->user = $user;
        $this->exam = $exam;
        $this->objPHPWord = new PHPWord();

        $this->grades = new Grade;
        $this->grade = $this->grades->gradeStudent($exam, $user);
        $this->subjectsScore = $this->grades->allStudentsBySubject($exam)
            ->where('id', $user->id)->sortBy('text');
        $this->questions_count = $exam->questions_count();
        $this->questionsInExam = $exam->questionsBySubject();
        $this->status = $user->exams->find($exam)->pivot;
    }

    /**
     *
     * @return void
     * @author msantana
     */
    /**
     * undocumented function
     *
     * @return void
     */
    public function create()
    {
        $fileName = 'Reporte_'.$this->exam->board_id.'_'.Carbon::now()->toAtomString();
        setlocale(LC_TIME, 'es_ES.utf8');
        $document = $this->objPHPWord->loadTemplate(storage_path('app/wordTemplates/reports/singleUser.docx'));
        $document->setValue('boardName', $this->exam->board->name);
        $document->setValue('year', $this->exam->applicated_at->year);
        $document->setValue('month', $this->exam->applicated_at->format('F'));
        $document->setValue('fullName', $this->user->full_name());
        $document->setValue('name', $this->user->name);
        $document->setValue('lastName', $this->user->last_name);
        $document->setValue(
            'hierachy',
            $this->grades->hierachy($this->exam)->where('id', $this->user->id)->first()['hierachy']
        );
        $document->setValue('studentsNumber', $this->grades->hierachy($this->exam)->count());
        if ($this->user->center != null) {
            $document->setValue('center', $this->user->center->name);
        } else {
            $document->setValue('center', '');
        }
        $document->setValue('completionYear', $this->user->completion_year);
        $document->cloneRow('subjectRow', $this->subjectsScore->count());
        $i = 1;
        $questionsNumber = 0;
        $subjectScorePercentSum = 0;
        $questionsInExam = $this->exam->questions_count();
        foreach ($this->subjectsScore as $subjectScore) {
            $questionsInSubject = $this->questionsInExam->where('text', $subjectScore->text)->first();
            $document->setValue('subjectRow#'.$i, $subjectScore->text);
            $document->setValue('subjectNumber#'.$i, $questionsInSubject->questionsNumber);
            $document->setValue(
                'subjectNumberPercent#'.$i,
                Helper::percentage($questionsInExam, $questionsInSubject->questionsNumber)
            );
            $document->setValue('subjectScore#'.$i, $subjectScore->points);
            $document->setValue('subjectScoreMiss#'.$i, $questionsInSubject->questionsNumber - $subjectScore->points);
            $scorePercent = round(($subjectScore->points/$questionsInSubject->questionsNumber)*100, 2);
            $document->setValue(
                'subjectScorePercent#'.$i,
                /*round(($subjectScore->points/$questionsInSubject->questionsNumber)*100, 2)*/ $scorePercent
            );
            $document->setValue(
                'subjectScoreMissPercent#'.$i,
                round(
                    ($questionsInSubject->questionsNumber - $subjectScore->points)/($questionsInSubject->questionsNumber)*100,
                    2
                )
            );
            $i++;
            $questionsNumber += $questionsInSubject->questionsNumber;
            $subjectScorePercentSum += $scorePercent;
        }
        $document->setValue('questionsNumber', $questionsNumber);
        $document->setValue('questionsNumberPercent', round($questionsNumber/$this->exam->questions_count(), 2)*100);
        $document->setValue('score', $this->grade);
        $document->setValue('scoreMiss', $questionsNumber - $this->grade);
        //$document->setValue('scorePercent', round($subjectScorePercentSum /$i, 2));
        $document->setValue('scorePercent', Helper::statsRound($subjectScorePercentSum));
        $document->setValue('scoreMissPercent', 100 - round($subjectScorePercentSum /$i, 2));
        return $document->save(public_path($fileName));
        //return storage_path().'/'.$fileName;
    }
    /**
     * Creates the basic template for the reports
     * since PHPWord cannot replace placeholder images
     * this function must get the name and the logo of
     * the board and the clonable sections to insert
     * the actual report
     *
     * @return PHPWord object
     * @author msantana
     */
    public function createTemplate()
    {
        //Getting the board logo
        $logo = $this->exam->board->logo->first()->source;
        //Preparing th generarl orintation of the main section
        //For this kind of reports it is always portrait
        $sectionStyle = [
            'orientation' =>  'portrait',
            'marginTop' => 600,
            'colsNum' => 1,
        ];
        //Preparing the "small" image to be
        //used in the header of all the document
        $imageStyle = [
           'height' => 80,
           'wrappingStyle' => 'square',
           'posHorizontalRel' => 'margin',
           'posVerticalRel' => 'line',
        ];
        //Create the section
        $section = $this->objPHPWord->addSection($sectionStyle);
        //Create an empty header
        $header = $section->addHeader();
        //Preparing a table to insert in the heading
        //to accomodate the image on the left and
        //the name of the board on the right
        $tableStyle = [
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 50
        ];
        $firstRowStyle = array('bgColor' => '66BBFF');
        $this->objPHPWord->addTableStyle('headerTable', $tableStyle, $firstRowStyle);

        $headerTable = $header->addTable('headerTable');
        $headerTable->addRow();
        $cell = $headerTable->addCell();

        $source = "images/".$logo;
        $cell->addImage($source, $imageStyle);
        $cell = $headerTable->addCell();
        $cell->addText($this->exam->board->name, array('name' => 'Arial', 'size' => 11));
        $cell = $headerTable->addCell();
        $cell->addText(
            "Examen de Certificación ".$this->exam->applicated_at->year,
            array('name' => 'Arial', 'size' => 14)
        );
        $testTextSection = $this->objPHPWord->addSection();
        $testTextSection->addText(
            'Cogito ergo sum',
            ['name' => 'Tahoma', 'size' => 32]
        );
        //Save and return
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->objPHPWord, 'Word2007');
        $fileName = 'Reporte_'.$this->exam->board_id.'_'.Carbon::now()->toAtomString().".docx";
        $savePath = storage_path('wordTemplates/'.$this->exam->board->id);
        if (!File::exists($savePath)) {
            return File::makeDirectory($savePath, 0775, true);
        }
        /*
        if (!File::isDirectory($savePath)) {
            File::makeDirectory(storage_path('wordTemplates/'.$this->exam->board->id), 0755, true);
        }
         */
        $objWriter->save($savePath);
        //File::put($fileName, $objWriter->save($fileName));
        //return public_path($fileName);
        //return $objWriter->save("php://output");
        //$document->save(public_path($fileName));
        //$writer = PHPWord_IOFactory::createWriter($objPHPWord, 'Word2007');;
        //$writer->save("testword.docx");
        return Response::download($savePath, $fileName);
    }
}
