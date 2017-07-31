<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add columns
        Schema::table('users', function ($table) {
            $table->integer('center_id')->unsigned()->nullable();
            $table->smallInteger('completion_year')->unsigned();
            $table->date('birth')->nullable();
            $table->enum('gender', ['m', 'f']);
        });

        //Create foreign keys
        Schema::table('users', function ($table) {
            $table->foreign('center_id')->references('id')->on('centers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function ($table) {
            $table->dropColumn('center_id');
            $table->dropColumn('completion_year');
            $table->dropColumn('birth');
            $table->dropColumn('gender');
        });
    }
}
