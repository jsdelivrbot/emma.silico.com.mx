<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //Create foreign keys
       /* Schema::table('slots', function ($table){
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
        Schema::table('distractors', function ($table){
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
