<?php

namespace EMMA5\Http\Middleware;

use Closure;
use Auth;
use Carbon;
use EMMA5\Exam;

class CheckExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $examId = session('exam_id');
        $status = Auth::user()->exams->find($examId)->pivot;
        $now = Carbon::now();
        $exam = Exam::find($examId);
        $endExamTime = $exam->applicated_at->addMinutes(Exam::find($examId)->duration);
        //$endExamTime = $exam->applicated_at->addMinutes(Exam::find($examId)->duration);
        session(['checkExam' => $status]);
        if ($status->active != 1) {
            return redirect('home');
        } elseif (!isset($status->started_at)) {
            return redirect('home');
        } elseif ($now > $endExamTime) {//TODO compare vs the actual time in the exam NOT the hour
            Carbon::setLocale('es');
            $message = 'Su tiempo de examen ha sido exedido por '. $now->diffForHumans($endExamTime);
            flash($message, 'danger')->important();
        } elseif (Auth::user()->id != $status->user_id) {
            return redirect('home');
        }

        return $next($request);
    }
}
