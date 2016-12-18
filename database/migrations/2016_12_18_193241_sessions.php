<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
            $table->smallInteger('f1');
            $table->smallInteger('f2');
            $table->smallInteger('f3');
            $table->smallInteger('f4');
            $table->smallInteger('f5');
            $table->smallInteger('f6');
            $table->smallInteger('f7');
            $table->smallInteger('f8');
            $table->smallInteger('f9');
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
    }
}
