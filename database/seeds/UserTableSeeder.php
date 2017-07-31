<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('users')->insert([
            'name'      => "Marco Antonio",
            'last_name' => "Santana",
            'email'     => "marco.santana@gmail.com",
            'password'  => bcrypt('password')
        ]);

        for ($amount_users=0; $amount_users < 900; $amount_users++) {
            DB::table('users')->insert([
            'name'      => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email'     => $faker->email(),
            'password'  => bcrypt('password')
        ]);
        }
    }
}
