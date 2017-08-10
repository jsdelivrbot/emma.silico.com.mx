<?php

namespace EMMA5\Http\Controllers;

// use EMMA5\Http\Controllers\Controller;
use EMMA5\Exam;
use EMMA5\User;
use EMMA5\Grade;
use EMMA5\Slot;
use Illuminate\Http\Request;
use EMMA5\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Excel;
use PHPExcel;

class ExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO eager loading for users and preparation for statistics
        $exams = Exam::all()->sortBy('created_at');
        $users = User::all();
        return view('management.exams.index', compact('exams', 'users'));
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param type var Description
     * @return return type
     */
    public function user_dashboard()
    {
        //falta eager load de exámenes
        $user = Auth::user();
        return view('exams.user_dashboard', compact('user'));
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param type var Description
     * @return return type
     */
    public function start(Request $request)
    {
        $user = Auth::user();

        if ($user->id == $request->user_id) {
            $status = $user->exams->find($request->exam_id)->pivot;
            if (!isset($status->started_at)) {
                $status->started_at = Carbon::now();
            }
            $status->active = 1;
            $status->seat = $request->seat;
            $status->save();

            $exam = Exam::find($request->exam_id);
            // Via the global helper...
            session(['exam_id' => $exam->id]);



            $message = 'Examen iniciado a:'.$status->started_at;
            flash($message, 'success')->important();
            return redirect()->action('ExamController@generalIndex');
        } else {
            abort(500);
        }
    }

    public function generalIndex(Request $request)
    {
        // find($request->exam_id)->
        $exam = Exam::with(
                        [ 'slots.vignettes',
                        'slots.questions',
                        'slots.questions.answers' => function ($query) {
                            $query->where('answers.user_id', '=', Auth::user()->id);
                        }, ]
                )
                ->where('id', '=', session('exam_id'))
                ->get();

        // $exam = Exam::with('slots.questions')->where('id', '=', session('exam_id'))->get();
        //$slot = $exam->slots->first();
        return view('exams.slots_list', compact('exam'));
        // return view('exams.show', compact('slot', 'answers'));
    }

    public function answerSlot(Slot $slot)
    {
        $previousSlot = Slot::where('exam_id', '=', $slot->exam_id)->where('id', '<', $slot->id)->max('id');
        $nextSlot = Slot::where('exam_id', '=', $slot->exam_id)->where('id', '>', $slot->id)->min('id');

        $slot->load([
                        'vignettes',
                        'questions.distractors',
                        'questions.answers' => function ($query) {
                            $query->where('answers.user_id', '=', Auth::user()->id);
                        }]);


        return view('exams.show', compact('slot', 'answers', 'previousSlot', 'nextSlot'));
    }

    public function finish(Request $request)
    {

                // return $request;
        $user = Auth::user();
        $exam = Exam::find($request->exam_id);
        $slots = $exam->slots->load('questions');

        $questionsCount = 0;
        foreach ($slots as $slot) {
            $questionsCount += $slot->questions->count();
        }

        $grade = new Grade;
        $answersCount = $grade->answersCount($exam, $user);
        $userGrade = $grade->gradeStudent($exam, $user);

        $examUser = $user->exams->find($request->exam_id)->pivot;

        if (!isset($examUser->ended_at)) {
            $examUser->ended_at = Carbon::now();
        }

        $examUser->active = 0;
        $examUser->save();
        // return "examen finalizado a las: ".$examUser->ended_at;
        return view('exams.finish', compact('exam', 'examUser', 'userGrade', 'answersCount', 'questionsCount'));
    }

    /*These are for management*/

    /**
     *Return the asociated users with given exam
     *for use with ajax
     *
     *@return \Illuminate\Http\Response
     */
    public function users_exam(Request $request)
    {
        if ($request->isMethod('post')) {
            $exam = Exam::find($request->exam_id);
            $users = $exam->users;
            return $users;

            //return response($users, $httpStatusCode = 200);
        } elseif ($request->isMethod('get')) {
            return response($users);
        }
    }

    /**
     * Resturns the top graded students
     *
     * Grades the $top students and returns blade partial with  unordered-list with ids and scores
     *
     * @param Exam $exam Instance of the Exam to be graded
     * @param int $top Size of the top list
     * @return json object
     */
    public function top_students(Exam $exam, $top)
    {
        //Must call the hierachy so it can be displayed on the view
        //change with-> to compact
        $grades = new Grade;
        $hierachy = $grades->hierachy($exam);
        $topStudents = $grades->topStudents($exam, $top);
        $gradedStudents = $topStudents->each(function ($student) use ($hierachy, $grades) {
            $currentHierachy = $hierachy->where('id', $student->id)->pluck('hierachy');
            return $student->hierachy = $currentHierachy[0];
        });
        return view('management.exams.top_bottom_students_list_partial', compact('gradedStudents'));
    }

    /**
     * Returns the lowest graded students
     *
     * Grades the $bottom students and returns blade partial with  unordered-list with ids and scores
     *
     * @param Exam $exam Instance of the Exam to be graded
     * @param int $bottom Size of the bottom list
     * @return json object
     */
    public function bottom_students(Exam $exam, $top)
    {
        $grades = new Grade;
        $hierachy = $grades->hierachy($exam);
        $bottomStudents = $grades->bottomStudents($exam, $top);
        $gradedStudents = $bottomStudents->each(function ($student) use ($hierachy, $grades) {
            $currentHierachy = $hierachy->where('id', $student->id)->pluck('hierachy');
            return $student->hierachy = $currentHierachy[0];
        });
        return view('management.exams.top_bottom_students_list_partial', compact('gradedStudents'));
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param type var Description
     * @return return type
     */
    public function grade_all(Exam $exam)
    {
        $grades = new Grade;
        return $usersGrades = $grades->allStudents($exam);
        ;
    }

    public function show(Exam $exam)
    {
        // return $exam;
        $exam = $exam->load('slots.questions.distractors');
        // return view('management.exams.show');
        return view('management.exams.show', compact('exam'));
    }

    /**
     * Creates a partial with the rendered chart for the given exam
     *
     * Rturns html with chart composed of the points for all studients in the given exam
     *
     * @param type var Description
     * @return return type
     */
    public function grade_all_chart(Exam $exam)
    {
        $grades = new Grade;
        $usersGrades = $grades->allStudents($exam);
        foreach ($usersGrades as $user) {
            $ids[] = $user->id;
            $points[] = $user->points;
            $pointsAverage = array_sum($points) / count($points);
        }
        return view('management.exams.grades_chart_partial', compact('ids', 'points', 'pointsAverage'));
    }

    /**
     * Return student point
     *
     * Gives integer with the scored points
     *
     * @param Exam object via Request, User object via Request
     * @return return int
     */
    public function grade_student(Exam $exam, User $user)
    {
        $grades = new Grade;
        return $studentGrade = $grades->gradeStudent($exam, $user);
    }


    /**
     * Returns a spreadsheet with only the students that were present
     *
     * @return PHPOffice
     */
    public function gradesSpreadshet(Exam $exam)
    {
        $grade = new Grade;
        $board = $exam->board;

        //If a create a helper to add as a last array item the dynamically generated formula
        //Must know the desired column to append as its last cell
        //Must know the desired formula
        //Must know if using a title/header to be used or ignored
        $data = Helper::collectionToArray($grade->allStudentsWithData($exam)->toArray());
        return Excel::create(
                        "CalificacionFinal".$board->shortName().$exam->applicated_at->toDateString(),
                    function ($excel) use ($data, $exam, $grade) {
                        $excel->sheet(
                            'Primera hoja',
                            function ($sheet) use ($data, $exam, $grade) {
                                $sheet->fromArray($data);
                                $sheet->row(
                                        1, function($row) {
                                                // call cell manipulation methods
                                                $row->setBackground('#074DFE');
                                        }
                                );
                                $highestColumn = $sheet->getHighestColumn();
                                $highestRow = $sheet->getHighestRow();


                                // Append row as very last
                                $sheet->appendRow(array($highestColumn, $highestRow ));

                                $sheet->cell($highestColumn.$highestRow, function($cell) use($highestColumn, $highestRow) {

                                    // manipulate the cell
                                    $cell->setValue('=AVERAGE('.$highestColumn."2:".$highestColumn.($highestRow-1).")");

                                });

                                // Set auto size for sheet
                                $sheet->setAutoSize(true);
                            }
                        );
                        $excel->sheet(
                            'Segunda hoja',
                            function ($sheet) use ($data, $exam, $grade) {
                                $sheet->fromArray();
                            }
                        );
                    }
        )->export('xlsx');
    }
}
