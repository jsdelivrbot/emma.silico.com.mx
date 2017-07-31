<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CatTableSeeder::class);
        $this->call(QuotesTableSeeder::class);
        $this->call(SlotsVignettesSeeder::class);
        $this->call(QuestionsSeeder::class);
    }
}
