<?php

use Illuminate\Database\Seeder;

class PopulateExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $slots_ammount = 60;//This is for standar exam
        $users_ammount = 150;

        $exam = EMMA5\Exam::first();
        $slots = EMMA5\Slot::orderBy('order', 'asc')->take($slots_ammount)->get();
        foreach ($slots as $slot) {
            $exam->slots()->save($slot);
        }
        $users = EMMA5\User::orderBy('id', 'asc')->take($users_ammount)->get();
        foreach ($users as $user) {
            $exam->users()->save($user);
        }
    }
}
