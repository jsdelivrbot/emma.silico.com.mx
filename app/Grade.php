<?php
/**
 * Undocumented class
 *
 * @author msantana
 */
namespace EMMA5;

use EMMA5\Libraries\Statistics as Stats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Grade extends Model
{
    /*Functions for single user */
    //Función para calificar un sustentantes devuelve conteo de respuestas correctas (int)
    public function gradeStudent(Exam $exam, User $user)
    {
        return $result = DB::table('answers')
            /*->max('answers.updated_at')*/
            ->leftJoin('distractors', 'answers.question_id', '=', 'distractors.question_id')
            ->where('answers.user_id', $user->id)
            //consultar si el sustentante presentó el examen
            ->where('answers.exam_id', $exam->id)
            ->whereRaw('distractors.option = answers.answer')
            ->where('distractors.correct', 1)
            ->count();
    }

    public function answersCount(Exam $exam, User $user)
    {
        return $result = $exam->users->find($user->id)
            ->answers()
            ->where('user_id', '=', $user->id)
            ->get()
            ->count();
    }
    //Función para saber si el sustentante pasó según línea de corte (passing_grade)
    public function passed(Exam $exam, User $user)
    {
        return $this->gradeStudent($exam, $user) >= $exam->passing_grade ? true : false;
    }

    /* End of functions for single user */
    /**
     * Grade all the students
     *
     * Grades all the students for a given exam returning a JSON with the user id, names and points aquired.
     *
     * @param Exam
     * @return json Object
     */
    public function allStudents(Exam $exam)
    {
        return DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('users.id, count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->orderBy('points', 'desc')
            ->groupBy('users.id')
            ->get();
    }

    public function allStudentsBySubject(Exam $exam)
    {
        return DB::table('questions')
            ->select(
                'subjects.text',
                'users.id',
                'users.name',
                'users.last_name',
                DB::raw('count(answers.id) as points')
            )
            ->leftJoin('slots', 'questions.slot_id', '=', 'slots.id')
            ->leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->leftJoin('subjects', 'slots.subject_id', '=', 'subjects.id')
            ->leftJoin('users', 'answers.user_id', '=', 'users.id')
            ->leftJoin('distractors', 'questions.id', '=', 'distractors.question_id')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->whereRaw('answers.answer = distractors.option')
            ->groupBy('subjects.text')
            ->groupBy('users.name')
            ->groupBy('users.last_name')
            ->groupBy('users.id')
            ->groupBy('subjects.id')
            ->orderBy('users.id')
            ->get();
    }

    function allStudentsWithData(Exam $exam)
    {
        return DB::table('users')
            ->select(
                'users.id as Identificador',
                'users.identifier as Folio',
                'users.name as Nombre',
                'users.last_name as Apellidos',
                'centers.name as Sede'
                )
            ->selectRaw('count(distractors.id) as Puntos')
            ->join('exam_user', 'exam_user.user_id', '=', 'users.id')
            ->join('answers', 'users.id', '=', 'answers.user_id')
            ->join('centers', 'users.center_id', '=', 'centers.id')
            ->join('distractors', 'answers.question_id', 'distractors.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->whereRaw('exam_user.exam_id = ' . $exam->id)
            ->whereRaw('distractors.correct = '. 1)
            ->whereNotNull('exam_user.started_at')
            ->groupBy('answers.user_id')
            ->get();
    }

    public function avgSubject(Exam $exam)
    {
        //return $this->allStudentsBySubject($exam)->groupBy('text');
        $result = collect();
        return $this->allStudentsBySubject($exam)->groupBy('text')->each(function ($subject) use ($result) {
            return $result->push(['text' => $subject]);
            //return $subject->avg('points');
        });
    }

    /**
     * Incomplete method
     */
    public function avgSubjectTop(Exam $exam)
    {
        /**
         * $collection = collect([1, 2, 3, 4, 5]);

        $multiplied = $collection->map(function ($item, $key) {
        return $item * 2;
        });

        $multiplied->all();

        // [2, 4, 6, 8, 10]
         */
        $topStudents = $this->topStudents($exam);
        $topStudentsSubjects = $topStudents->map(function ($value, $key) {
        });
    }

    public function groupByQuestion(Exam $exam)
    {
        return DB::table('questions')
            ->select('questions.id', DB::raw('count(answers.id) as points'))
            ->leftJoin('slots', 'questions.slot_id', '=', 'slots.id')
            ->leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->leftJoin('distractors', 'questions.id', '=', 'distractors.question_id')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->whereRaw('answers.answer = distractors.option')
            ->groupBy('questions.id')
            ->orderBy('questions.id')
            ->get();
    }

    /**
     * Mean of the grades all the students
     *
     * Grades all the students for a given exam.
     *
     * @param Exam
     * @return float
     */
    public function meanAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id)'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        $data = json_decode(json_encode((array) $grades), true);
        $data = array_flatten($data);
        $data = array_values($data);

        return Stats::mean($data);
    }

    /**
     * Stdv of the grades all the students
     *
     * Calculates teh standard deviation of all the grades for a given exam returns float.
     *
     * @param Exam
     * @return float
     */
    public function stdvAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id)'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        $data = json_decode(json_encode((array) $grades), true);
        $data = array_flatten($data);
        $data = array_values($data);

        return Stats::standardDeviation($data);
    }

    /**
     * Range of the grades all the students
     *
     * Calculates the range of all the grades for a given exam returns float.
     *
     * @param Exam
     * @return float
     */
    public function rngAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id)'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        $values = json_decode(json_encode((array) $grades), true);
        $values = array_flatten($values);
        $values = array_values($values);

        return Stats::range($values);
    }

    /**
     * Range of the grades all the students
     *
     * Calculates the range of all the grades for a given exam returns float.
     *
     * @param Exam
     * @return float
     */
    public function maxAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        //return $grades->max()->points;
        $values = json_decode(json_encode((array) $grades), true);
        $values = array_flatten($values);
        $values = array_values($values);
        return Stats::max($values);
    }
    /**
     * Range of the grades all the students
     *
     * Calculates the range of all the grades for a given exam returns float.
     *
     * @param Exam
     * @return float
     */
    public function minAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        //return $grades->max()->points;
        $values = json_decode(json_encode((array) $grades), true);
        $values = array_flatten($values);
        $values = array_values($values);
        return Stats::min($values);
    }

    /**
     * Variance of the grades all the students
     *
     * Calculates the range of all the grades for a given exam returns float.
     *
     * @param Exam
     * @return float
     */
    public function varianceAllStudents(Exam $exam)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->groupBy('users.id')
            ->get();

        //return $grades->max()->points;
        $values = json_decode(json_encode((array) $grades), true);
        $values = array_flatten($values);
        $values = array_values($values);
        return Stats::variance($values);
    }

    public function varianceAllQuestions(Exam $exam)
    {
        $grades = $this->groupByQuestion($exam)->pluck('points');
        $studentsNumber = $exam->users()->count();
        $p = $grades->map(function ($points) use ($studentsNumber) {
            return 1-($points/$studentsNumber);
        });
        return $p;
    }

    public function alpha(Exam $exam)
    {
        $grades = $this->groupByQuestion($exam)->pluck('points');
        $studentsNumber = $exam->users()->count();
        $pQ = $grades->map(function ($points) use ($studentsNumber) {
            return ($points/$studentsNumber)*(1-($points/$studentsNumber));
        });
        $numQuestions = $exam->questions_count();
        try {
            $alpha = $numQuestions/($numQuestions-1)*(1-$pQ->sum()/$this->varianceAllStudents($exam));
        } catch (Exception $e) {
            return 0;
        }
        return $alpha;
    }

    /**
     * Grade top #  students for use with ajax
     *
     * Grades # the students with the highest grades for a given exam
     * returning a JSON with the user id, names and points aquired.
     *
     * @param Exam id
     * @param  int $top
     * @return collection
     */
    public function topStudents(Exam $exam, $top = null)
    {
        isset($top) ? :$top = 5;

        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('users.id, users.name, users.last_name, count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->orderBy('points', 'desc')
            ->groupBy('users.id')
            ->limit($top)
            ->get();
        return $grades;
    }

    /**
     * Grade bottom #  students for use with ajax
     *
     * Grades # the students with the lowest grades for a given exam returning a JSON with the user id, names and points aquired.
     *
     * @param Exam id
     * @param  int $top
     * @return  collection
     */
    public function bottomStudents(Exam $exam, $bottom = null)
    {
        isset($bottom) ? :$bottom = 5;

        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('users.id, users.name, users.last_name, count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->orderBy('points', 'asc')
            ->groupBy('users.id')
            ->limit($bottom)
            ->get();
        return $grades;
    }

    /**
     * Gets the quantiles of the grades of the students
     *
     * Returns the students graded and ordered in the given quantiles
     *
     * @param  Exam $exam Given exam
     * @param  int $quantilesNumber Number of quantiles
     * @param  int $quantile Desired quantile (optional). If not given returns all data
     *
     * @return return type
     */
    public function quantile(Exam $exam, $quantilesNumber, $quantile = null)
    {
        $grades = DB::table(DB::raw('users, answers, distractors'))
            ->select(DB::raw('users.id, users.name, users.last_name, count(answers.id) as points'))
            ->whereRaw('users.id = answers.user_id')
            ->whereRaw('distractors.question_id = answers.question_id')
            ->whereRaw('distractors.option = answers.answer')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->orderBy('points', 'desc')
            ->groupBy('users.id')
            ->get();

        $grades = $grades->chunk($quantilesNumber);


        return $grades;
    }

    /**
    * Sorts students by the total score in the exam if two or more
    * students have the same score then they have the same hierachy
    * but the count keeps on
    *
    * @param class $exam An EMMA5\Exam instance
    *
    * @return collect
    */
    public function hierachy(Exam $exam)
    {
        $grades = $this->allStudents($exam);
        $scores =  $grades->sortByDesc('points');
        $position = 1;
        $hierachy = 1;
        $tempScore = 0;
        $usersByHierachy = collect();
        foreach ($scores as $score) {
            if ($score->points === $tempScore) {
                $hierachy = $tempHierachy;
            } else {
                $hierachy = $position;
            }
            $usersByHierachy->push(
                [
                    'id' => $score->id,
                    'points' => $score->points,
                    'hierachy' => $hierachy
                ]
            );
            $tempHierachy = $hierachy;
            $tempScore = $score->points;
            $position++;
        }
        return $usersByHierachy;
    }
}
