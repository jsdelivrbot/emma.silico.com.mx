<?php

namespace EMMA5;

//namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;
use Hash;
use DB;
use Avatar;
use File;
use Helper;

/**
 * @property mixed last_name
 * @property mixed name
 * @property mixed center_id
 * @property mixed board_id
 */
class User extends Authenticatable
{
    use Notifiable;
    use NtrustUserTrait; // add this trait to your user model

    /*
    * Role profile to get value from ntrust config file.
    */
    protected static $roleProfile = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'username', 'email', 'password', 'center_id', 'board_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*Mutator for password hashing*/
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    //Relations
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function exams()
    {
        return $this->belongsToMany('EMMA5\Exam')->withPivot('active', 'started_at', 'ended_at', 'location_id');
    }

    public function locations()
    {
        return $this->belongsToMany('EMMA5\Location', 'exam_user')->withPivot('location_id', 'seat');
    }

    public function center()
    {
        return $this->belongsTo('EMMA5\Center');
    }

    public function avatar()
    {
        return $this->morphMany('EMMA5\Image', 'imageable');
    }

    public function board()
    {
        return $this->belongsTo('EMMA5\Board');
    }


    //Querying methods
    public function answer($question_id)
    {
        // return $this->hasOne(Answer::class)->where('id', $answer_id);
        return $this->answers->where('question_id', $question_id);
    }

    /**
     * Returns the most recent answer for the givem exam
     *
     * @return collect
     * @author msantana
     */
    public function latestAnswer(Exam $exam)
    {
        //$latestAnswer = $this->answers->where('exam_id', $exam->id)->orderBy('updated_at', 'desc')->first();
        $latestAnswer = DB::table('answers')
            ->where('user_id', $this->id)
            ->where('exam_id', $exam->id)
            ->latest('updated_at')
            ->limit(1)
            ->get()
            ->first();
        return $latestAnswer;
    }

    /**
     * Returns a collection with the answers for the given exam
     *
     * @return collect
     * @author msantana
     */
    public function answersBySubject(Exam $exam)
    {
        //At this point this returns the subjects if the given exam
        //TODO join it with the answers of the user in the given exam
        return DB::table('subjects')
            ->join('slots', 'slots.subject_id', '=', 'subjects.id')
            ->join('exams', 'exams.id', '=', 'slots.exam_id')
            ->join('questions', 'questions.slot_id', '=', 'slots.id')
            ->join('answers', 'answers.question_id', '=', 'questions.id')
            ->join('distractors', 'distractors.question_id', '=', 'questions.id')
            ->select('subjects.text', DB::raw('count(questions.id) as questionsNumber'))
            ->where('exams.id', $exam->id)
            ->where('answers.user_id', $this->id)
            ->select('answers.question_id as question_id', 'answers.id as answer_id', 'answers.answer', 'subjects.text')
            ->orderBy('questions.id', 'answers.text')
            ->get();
    }

    /**
     * Returns a string of the user name i.e. Name + LastName
     * If reverse set to true gives the LastName first
     *
     * @return string
     * @author msantana
     */
    public function full_name($reverse = null)
    {
        if ($reverse) {
            $full_name = $this->last_name." ".$this->name;
        } else {
            $full_name = $this->name." ".$this->last_name;
        }
        return $full_name;
    }

    /**
     * Returns a base64 encoded image with the user photo
     * if it does not exists creates an avatar with their initials
     *
     * @return string
     */
    public function photo()
    {
        if (isset($this->avatar->first()->source)) {
            $source = $this->avatar->first()->source;
        } else {
            $source = null;
            return Avatar::create($this->name." ".$this->last_name)->toBase64();
        }
        if (isset($this->board->id)) {
            $boardId = $this->board->id;
        } else {
            $boardId = null;
        }
        $filePath = 'images/avatars/users/'.$boardId.'/'.$source;
        if (File::exists(public_path($filePath))) {
            return Helper::imageBase64(public_path($filePath));
            return asset($filePath);
        } else {
            return Avatar::create($this->name." ".$this->last_name)->toBase64();
        }
    }
}
