<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        foreach (range(1, 50) as $index) {
            EMMA5\Cat::create([
                'name' => $faker->firstName(),
            ]);
        }
    }
}
