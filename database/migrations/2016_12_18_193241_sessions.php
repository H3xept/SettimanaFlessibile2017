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

        Schema::table('sessions', function($table){
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_user');
        Schema::drop('sessions');
    }
}
