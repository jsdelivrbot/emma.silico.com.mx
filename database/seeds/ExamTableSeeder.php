<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ExamTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
            EMMA5\Exam::create([
                'applicated_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
                'active'        => true,
                'duration'      => 180,
                'annotation'    => 'Examen comun'

            ]);
        }
    }
}
