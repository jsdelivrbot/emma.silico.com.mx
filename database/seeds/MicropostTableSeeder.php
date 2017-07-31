<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class MicropostTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        $faker = Faker\Factory::create();

        $limit = 300;
        $options = array(
            "symbol"        => 'a',
            "order"         => '1',
            "text"          => 'Blah blah',
            "correct"       => 'true',
            "weight"        => '1'
        );
        for ($i = 0; $i < $limit; $i++) {
            DB::table('microposts')->insert([ //,
                'title' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'body' => $faker->realText($maxNbChars = 200, $indexSize = 2)
            ]);
        }
    }
}
