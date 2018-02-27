<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Distractor;
use EMMA5\Question;
use Illuminate\Http\Request;
use EMMA5\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $questions = Question::all();
        return view('management.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
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
        $question = new Question();

        $question->question = $request->input("question");
        $question->options = "Blah";
        $question->stats = "Blah";

        $question->save();
        flash('Question saved successfully');
        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        //return $question->stats;

        $stats = json_decode($question->stats);
        $options = json_decode($question->options, true);
        //$options = (object) $options;
        return view('questions.show')->with(compact('question'))->with(compact('stats'))->with(compact('options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        return view('management.crud.questions.edit_form', compact('question'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param    Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question  $question)
    {
        //
        $question->update($request->all());
        flash('Pregunta actualizada', 'success')->important();

        // return back();
        return Redirect::to(URL::previous() . "#question_".$question->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Question $question
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function updateDistractors(Request $request, Question $question)
    {
        //
        if (isset($request->text)) {
            $question->text = $request->text;
        }
        if (isset($request->order)) {
            $question->order = $request->order;
        }

        $input = Input::all();
        if (isset($input['distractor_correct'])) {
            $distractors = $question->distractors;
            $distractors->each(function ($distractor) {
                $distractor->correct = 0;
                $distractor->save();
            });
            $requestCorrectDistractor =  Distractor::where('id', $input['distractor_correct'])->first();
            $requestCorrectDistractor->correct = true;
            $requestCorrectDistractor->save();
            $requestCorrectDistractor;
        }
        foreach ($request['distractor_text'] as $key => $val) {
            $distractor =  Distractor::where('id', $key)->first();
            //$distractor = Distractor::firstOrNew(['id' => $key, 'distractor' => $val, 'question_id' => $question->id]);
            preg_replace("/^\n{1,}/", '', $val);
            $distractor->distractor = $val;
            $distractor->save();
        }

        $question->save();
        //$question->update($request->all());
        flash('Distractor actualizado', 'success')->important();

        // return back();
        return Redirect::to(URL::previous() . "#question_".$question->id);
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
}
