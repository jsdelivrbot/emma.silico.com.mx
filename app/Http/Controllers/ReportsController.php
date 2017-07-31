<?php

namespace EMMA5\Http\Controllers;

use Carbon\Carbon;
use EMMA5\Exam;
use EMMA5\User;
use EMMA5\Grade;
use EMMA5\Board as Board;
use EMMA5\ItemAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;
use PhpOffice\PhpWord\PhpWord as PhpWord;
use EMMA5\Libraries\ReportUserDoc as userDoc;
use Helper;

class ReportsController extends Controller
{
    //  //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lists all aviable board / exam
     *
     * @return view
     * @author msantana
     */
    public function index()
    {
        $boards = \EMMA5\Board::all()->load('logo');
        return view('reports.index', compact('boards'));
    }
    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function aviable(Board $board)
    {
        $exams = $board->exams->load('users.center')->where('active', 1);
        $grade = new Grade();
        return view('reports.aviableReportsByBoard', compact('board', 'exams', 'grade'));
        return $exams;
    }
    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function singleStudent(User $user, Exam $exam)
    {
        $report = new userDoc($exam, $user);
        return Response::download($report->create());
    }
    

    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function template(Board $board)
    {
        //$template = new userDoc($exam, $user);
        //return $template->createTemplate();
        //return Response::download($template->createTemplate());
        return Response::download(Helper::createBoardTemplate($board));
    }
    public function users(Exam $exam)
    {
        $content = view('management.dashboard.main');
        $grade = new Grade();
        $studentsPoints = $grade->allStudents($exam);
        $subjectPoints = $grade->allStudentsBySubject($exam);
        //$subjectPointsGeneral = $grade->allStudentsBySubject($exam)->groupBy('text');


        $phpWord = new PhpWord;
        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => 600,
            'colsNum' => 1,
        );
        $imageStyle = array(
            'height' => 80,
            'wrappingStyle' => 'square',
            //'positioning' => 'absolute',
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        );

        $section = $phpWord->addSection($sectionStyle);
        $header = $section->addHeader();

        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );
        $firstRowStyle = array('bgColor' => '66BBFF');
        $phpWord->addTableStyle('headerTable', $tableStyle, $firstRowStyle);

        $headerTable = $header->addTable('headerTable');
        $headerTable->addRow();
        $cell = $headerTable->addCell();

        $source = "images/".$exam->board->logo()->first()->source ;
        $cell->addImage($source, $imageStyle);
        $cell = $headerTable->addCell();
        $cell->addText($exam->board->name, array('name' => 'Arial', 'size' => 14));
        $cell->addText("Examen de Certificación ".$exam->applicated_at->year, array('name' => 'Arial', 'size' => 14));

        /*
         * Resultados
         * Se obtuvo en el examen escrito un promedio de aciertos de 288, 85 % de las 335 preguntas aplicadas,
         * una puntuación superior de 309, 92 % aciertos, una puntuación inferior de 198, 59%, un rango de 111
         * aciertos, desviación estándar de 15.82 e índice de confiabilidad de 0.889.
         *
         * */
        $average =  $grade->allStudents($exam)->pluck('points')->avg();
        $questionsNumber = $exam->questions_count();
        $averagePercent = round($average/$questionsNumber, 2)*100;
        $maxExam = $grade->maxAllStudents($exam);
        $maxExamPercent = round($maxExam/$questionsNumber, 2)*100;
        $minExam = $grade->minAllStudents($exam);
        $minExamPercent = round($minExam/$questionsNumber, 2)*100;
        $range = $grade->rngAllStudents($exam);
        $stdv = round($grade->stdvAllStudents($exam), 2);
        $alpha = round($grade->alpha($exam), 2);

        $text = "Resultados
Se obtuvo en el examen escrito un promedio de aciertos de $average,  $averagePercent% de las $questionsNumber preguntas aplicadas, una puntuación superior de $maxExam, $maxExamPercent % aciertos, una puntuación inferior de $minExam, $minExamPercent%, un rango de $range aciertos, desviación estándar de $stdv e índice de confiabilidad de $alpha.";
        $section->addText($text);

        $section->addLine();


        $section->addText('Estadísticas', array('name' => 'Arial', 'size' => 12, 'bold' => true));
        $section->addPageBreak();

        //$section = $phpWord->addSection($sectionStyle);
        $section->addText('Resultados por alumno', array('name' => 'Arial', 'size' => 12, 'bold' => true));
        // Define table style arrays
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
        // Define cell style arrays
        $styleCell = array('valign'=>'center');
        // Define font style for first row
        $fontStyle = array('bold'=>true, 'align'=>'center');
        // Add table style
        $section->addTableStyle('resultsTableStyle', $styleTable, $styleFirstRow);


        foreach ($exam->users->sortBy('last_name') as $user) {
            $section->addLine();

            $nameTable = $section->addTable('nameTable');
            $nameTable->addRow(75);
            $nameTable->addCell(1200)->addText('Nombre', $fontStyle);
            $nameTable->addCell(5000)->addText($user->name." ".$user->last_name, $fontStyle);
            $nameTable->addRow(75);
            $nameTable->addCell(1200)->addText('Sede', $fontStyle);
            //$nameTable->addCell(6000)->addText($user->center->name, $fontStyle);

            $section->addLine();
            $hierachyTable = $section->addTable('hierachyTable');
            $hierachyTable->addRow(75);
            $hierachyTable->addCell(2400)->addText('Jerarquía', $fontStyle);
            $hierachyTable->addCell(1200)->addText('x', $fontStyle);
            $hierachyTable->addRow(75);
            $hierachyTable->addCell(2400)->addText('No. de sustentantes', $fontStyle);
            $hierachyTable->addCell(1200)->addText($exam->users()->count(), $fontStyle);

            $section->addLine();
            $scoreTable = $section->addTable('scoreTable');
            $scoreTable->addRow(75);
            $scoreTable->addCell(2400)->addText('Correctas', $fontStyle);
            $scoreTable->addCell(1200)
                ->addText(
                    $studentsPoints
                ->where('id', $user->id)
                ->pluck('points')
                ->avg(),
                $fontStyle
                );
            $scoreTable->addRow(75);
            $scoreTable->addCell(2400)->addText('Incorrectas', $fontStyle);
            $scoreTable
                ->addCell(1200)
                ->addText(
                    $exam->questions_count()-$studentsPoints
                    ->where('id', $user->id)
                    ->pluck('points')
                    ->avg(),
                    $fontStyle
                );

            $section->addLine();
            $statsTable = $section->addTable('statsTable');
            $statsTable->addRow(75);
            $statsTable->addCell(3600)->addText("Promedio de aciertos general", $fontStyle);
            $statsTable->addCell(1200)->addText($average, $fontStyle);
            $statsTable->addRow(75);
            $statsTable->addCell(3600)->addText("Puntuación máxima general", $fontStyle);
            $statsTable->addCell(1200)->addText($maxExam, $fontStyle);
            $statsTable->addRow(75);
            $statsTable->addCell(3600)->addText("Puntuación mínima general", $fontStyle);
            $statsTable->addCell(1200)->addText($minExam, $fontStyle);

            $section->addLine();
            $section->addText('Resultados por tema', $fontStyle);


            $styleTable = array('borderSize'=>2, 'borderColor'=>'006699', 'cellMargin'=>1, 'width' => 100);
            $styleFirstRow = array('borderBottomSize'=>5, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

            // Define cell style arrays
            $styleCell = array('valign'=>'center');

            // Define font style for first row
            $fontStyle = array( 'align'=>'center', 'font' => 'Arial', 'size' => 9, 'bold' => true);

            $section->addTableStyle('resultsTableStyle', $styleTable, $styleFirstRow);

            $table = $section->addTable('resultsTableStyle');


            $table->addRow(75);
            $table->addCell(4000, $styleCell)->addText('', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('General', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('Sede', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('Personal', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('', $fontStyle);

            $table->addRow(75);

            $table->addCell(4000, $styleCell)->addText('Tema', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('número', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('%', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('prom', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('%', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('prom', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('%', $fontStyle);

            $subjectGrades = $grade->avgSubject($exam);
            foreach ($subjectPoints->where('id', $user->id) as $subject) {
                $table->addRow(75);
                $table->addCell(4000, $styleCell)->addText($subject->text, $fontStyle);
                $table->addCell(1000, $styleCell)->addText(round($subjectGrades[$subject->text]->where('text', $subject->text)->avg('points')), $fontStyle);
                $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
                $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
                $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
                $table->addCell(1000, $styleCell)->addText($subject->points, $fontStyle);
                $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
            }
            $table->addRow(75);
            $table->addCell(4000, $styleCell)->addText('Total', $fontStyle);
            $table->addCell(1000, $styleCell)->addText($exam->questions_count(), $fontStyle);
            $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
            $table->addCell(1000, $styleCell)->addText('x', $fontStyle);
            $table->addCell(1000, $styleCell)->addText($subjectPoints->where('id', $user->id)->pluck('points')->sum(), $fontStyle);
            $table->addCell(1000, $styleCell)->addText(round($subjectPoints->where('id', $user->id)->pluck('points')->sum()/$exam->questions_count(), 2)*100, $fontStyle);

            $section->addPageBreak();
        }




        // Adding Text element to the Section having font styled by default...
        foreach ($exam->users->sortByDesc('answers') as $user) {
            $section->addText("Resultado del Sustentante".PHP_EOL, array('name' => 'Arial', 'size' => 14, 'bold' => true));
            $section->addText(
                htmlspecialchars(
                    $user->name." ".$user->last_name
                ),
                array('name' => 'Arial', 'size' => 12, 'bold' => true)
            );
            $section->addText($grade->gradeStudent($exam, $user));
            $section->addPageBreak();
        }

        // Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $path = public_path($exam->board_id.'/reports/'.'test'.rand(1, 100).'.docx');
        //$path = resource_path('assets/sass/app.scss');
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . 'test1.docx' . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        return $objWriter->save("php://output");
        $objWriter->save('test1.docx');

        //return Response::make($content,200, $headers);
    }

    public function itemAnalysis(Exam $exam)
    {
        $iteman = new ItemAnalysis($exam);
        return view('reports.item_analysis')->with('exam', $exam)->with('iteman', $iteman);
    }

    public function keyDump(Exam $exam)
    {
        set_time_limit(120);
        $questions = $exam->load('users')->questions;
        $exam = $exam->load('users.answers', 'questions');
        // return $exam->answers->where('user_id', 4327)->where('question_id', 37168);
        $stats = new \EMMA5\Libraries\StatsDumper($exam->id);
        //Esto debería de estar como método de StatsDumper
        $answers = $exam
            ->answers()
            ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
            ->get();
        return view('reports.dumper')
            ->with([
                'exam' => $exam,
                'questions' => $questions,
                'stats' => $stats,
            ]);
    }
}
