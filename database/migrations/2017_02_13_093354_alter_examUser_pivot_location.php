<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExamUserPivotLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add columns
        Schema::table('exam_user', function ($table) {
            $table->integer('location_id')->unsigned()->nullable();
            $table->smallInteger('seat')->unsigned();
        });


        //Create foreign keys
        Schema::table('exam_user', function ($table) {
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_user', function ($table) {
            $table->dropColumn('location_id');
            $table->dropColumn('seat');
        });
    }
}
