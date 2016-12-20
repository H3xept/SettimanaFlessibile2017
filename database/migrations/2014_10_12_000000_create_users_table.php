<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('f1')->nullable();
            $table->smallInteger('f2')->nullable();
            $table->smallInteger('f3')->nullable();
            $table->smallInteger('f4')->nullable();
            $table->smallInteger('f5')->nullable();
            $table->smallInteger('f6')->nullable();
            $table->smallInteger('f7')->nullable();
            $table->smallInteger('f8')->nullable();
            $table->smallInteger('f9')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::drop('users');
    }
}
