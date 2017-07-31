<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVignetteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vignettes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slot_id')->nullable(false);
            $table->smallInteger('order');
            $table->text('text')->nullable(false);
            $table->string('instructions');
            $table->timestamps();
        });

        //        Schema::table('vignettes', function ($table){
//            $table->foreign('slot_id')->references('id')->on('slots');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vignettes');
    }
}
