<?php
/**
 * Created by PhpStorm.
 * User: marcosantana
 * Date: 06/02/17
 * Time: 07:52
 */

namespace EMMA5;

class ItemAnalysis
{
    public function __construct(Exam $exam)
    {
        $this->grade = new Grade();
        $this->exam = $exam;
    }
    public function difficultyGeneral()
    {
        //$grade = new Grade();
        $studentsCount = $this->grade->allStudents($this->exam)->count();
        $topStudents = $this->grade->topStudents($this->exam, round($studentsCount / 3));
        $bottomStudents = $this->grade->bottomStudents($this->exam, round($studentsCount / 3));
        return $topStudents->pluck('points')->avg() - $bottomStudents->pluck('points')->avg();
    }

    public function avgTop()
    {
        //$grade = new Grade();
        return $this->grade->topStudents($this->exam, round($this->grade->allStudents($this->exam)->count()/4))->pluck('points')->avg();
    }

    public function avgBottom()
    {
        //$grade = new Grade();
        return $this->grade->bottomStudents($this->exam, round($this->grade->allStudents($this->exam)->count()/4))->pluck('points')->avg();
    }
}
