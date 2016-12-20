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
            $table->integer('course_id')->unsigned()->nullable();
            $table->smallInteger('f1')->default('0');
            $table->smallInteger('f2')->default('0');
            $table->smallInteger('f3')->default('0');
            $table->smallInteger('f4')->default('0');
            $table->smallInteger('f5')->default('0');
            $table->smallInteger('f6')->default('0');
            $table->smallInteger('f7')->default('0');
            $table->smallInteger('f8')->default('0');
            $table->smallInteger('f9')->default('0');
            $table->smallInteger('sessionNumber')->default('0');
            $table->integer('maxStudents')->default(30);
            $table->integer('signedStudents')->default(0);
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
