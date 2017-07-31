<?php

namespace EMMA5\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*return view('home');*/
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return view('management.dashboard.main');
        } else {
            return redirect()->action('ExamController@user_dashboard');
        }
    }
}
