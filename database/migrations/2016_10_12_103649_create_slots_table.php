<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned()->index();
            $table->integer('subject_id')->unsigned()->index();
            $table->integer('order');
            $table->integer('exam_id');
            $table->string('instructions');
            $table->timestamps();
        });

        //Create foreign keys
        Schema::table('questions', function ($table) {
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade');
        });

        /*Schema::table('vignettes', function ($table){
            $table->foreign('slot_id')->references('id')->on('slots');
       });*/
//        Schema::table('slots', function ($table) {
//
//            $table->foreign('subject_id')->references('id')->on('subjects');
//        });
    }
    /**
     * Slot
    Order? (can be overriden for random order)
    Active (bool)
    Vignete (can be null)
    Question (can't be null)
    Photo? (can be null) polymorphic?
    Stats? (can be null) JSON?
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
