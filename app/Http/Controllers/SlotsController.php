<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Question;
use EMMA5\Slot;
use EMMA5\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use EMMA5\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SlotsController extends Controller
{
    /**
    Activates user auth
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
        //
        $slots = Slot::all();
        //        paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
        //        $slots = Slot::paginate(10, ['*'], 'page');


        return view('management.slots.index')->with(compact('slots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slot $slot)
    {
        //
        $user = Auth::user();
        $slot->load('questions')->with('answers')->where('user');
        //        return $answers = Auth::user()->with('answers')->where('questionslot_id', $slot->id)->get();
        $answers = Answer::where('user_id', $user->id)->get();
        //$answers = $user->answers();
        return view('management.slots.show')->with(compact('slot', 'user', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSlot($examId, $slotOrder)
    {
     return $this->where('exam_id', $examId)
        ->where('order', $slotOrder)
        ->get()
        ->first();
    }
}
