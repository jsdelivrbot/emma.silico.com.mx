<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Board;
use EMMA5\Exam;
use EMMA5\User;
use EMMA5\Grade;
use EMMA5\Libraries\Statistics;
use PDF;
use Intervention\Image\Facades\Image as Img;
use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;
use Stringy\Stringy as S;
use Illuminate\Support\Facades\Auth;

class AdministrationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /*if (Auth::user()->isAdministrator()) {*/
        return view('management.dashboard.main');
        /*  }
        else {
        return redirect()->route('login');
        return redirect()->action('HomeController@index');
      }*/
    }

    /**
    * Shows boards for administration
    *
    * Lists all boards only for admin users
    *
    * @return \Illuminate\Http\Response
    */
    public function indexBoards()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $boards = Board::orderBy('name')->get();
            return view('management.dashboard.list_boards', compact('boards'));
        } else {
            return redirect()->action('ExamController@user_dashboard');
        }
    }

    public function users_upload(Board $board)
    {
        // $board =  $board->load('exams');
        //$exams = Exam::where('board_id', '=', $board->id);
        //$exams = Exam::where('board_id', '=', $board->id)->pluck('applicated_at', 'id');
        $exams = $board->exams;
        return view('management.users.upload_csv', compact('exams', 'board'));
    }

    public function listBoardUsers(Board $board)
    {
        $board = $board->load('exams.users');
        return view('management.users.board_exam', compact('board'));
    }

    /* Users */
    public function createUsersPdf(Exam $exam)
    {
        if (Auth::user()->hasRole('admin')) {
            $exam = $exam->load('users');
            $users = $exam->users->load('avatar')->load('center');
            $board = $exam->board->load('logo');

            $pdf = PDF::loadView('management.users.passwords', compact('exam', 'users', 'board'));
            return $pdf->download('users'.$exam->id.'.pdf');
           // return view('management.users.passwords', compact('exam', 'users', 'board'));
        } else {
            return redirect()->action('ExamController@user_dashboard');
        }
    }

    public function addUsersAvatar(Board $board)
    {
        if (Auth::user()->hasRole('admin')) {
            $users = $board->users;
            $users->load('avatar');
        } else {
            return redirect()->action('ExamController@user_dashboard');
        }
    }

    /*Monitor*/
    public function monitorExams(Board $board)
    {
        $exams = Exam::where('board_id', '=', $board->id)->get();
        return view('management.monitor.monitor_exams_list', compact('exams', 'board'));
    }

    public function monitor(Exam $exam)
    {
        $grades = new Grade;
        $stats = new Grade;//Not necesary two instances of the dsame thing 
        $grades = $grades->allStudents($exam);
        $exam = $exam->load('users.answers', 'users.board', 'users.center');
        //$users = $exam->users;
        $questions_count = $exam->questions_count();
        $stringy = new S;//Maybe it can be called from the view
        return view('management.monitor.exam', compact('exam', 'users', 'grades', 'stats', 'questions_count', 'stringy'));
    }

    public function monitorStudent(Exam $exam, User $user)
    {
        $grades = new Grade;
        $grade = $grades->gradeStudent($exam, $user);
        $subjectsScore = $grades->allStudentsBySubject($exam)->where('id', $user->id);
        $questions_count = $exam->questions_count();
        $questionsInExam = $exam->questionsBySubject();
        $status = $user->exams->find($exam)->pivot;
        //Create a time lapse that seem right.
        ////Use the difference from exam start time to newest answer OR exam ended_at time
        //This is not working due to the wrong date format delivered to Carbon
        /*if ($status->ended_at == null) {*/
           $latestAnswer = $user->latestAnswer($exam)->updated_at;
            //Here i must use the newest answer
       /* }*/
        $examTime = Carbon::parse($status->started_at)->diffInMInutes(Carbon::parse($status->ended_at));
        return view(
            'management.monitor.student_status',
            compact(
                'exam',
                'user',
                'status',
                'grade',
                'subjectsScore',
                'questionsInExam',
                'questions_count',
                'examTime',
                'latestAnswer'
            )
        );
    }
    /* /Monitor */
}
