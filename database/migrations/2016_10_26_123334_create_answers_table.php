<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            //            $table->increments('id');
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullabel();
            $table->integer('question_id')->unsigned()->index();
            $table->char('answer');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('answers', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
