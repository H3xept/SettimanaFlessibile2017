<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoursesInstaller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_installer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('desc'); //Description
            $table->longText('ref'); //Referents
            $table->longText('pRef')->nullable(); //Professors
            $table->longText('ext')->nullable(); //Externals
            $table->boolean('type'); //Progressive == 1
            $table->smallInteger('f1'); //Lun 2
            $table->smallInteger('f2'); //Lun 3
            $table->smallInteger('f3'); //Mar 2
            $table->smallInteger('f4');
            $table->smallInteger('f5'); //Mer 2
            $table->smallInteger('f6');
            $table->smallInteger('f7'); //Gio 1
            $table->smallInteger('f8');
            $table->smallInteger('f9');
            $table->integer('maxStudentsPerSession')->default(30);
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
        Schema::drop('courses_installer');
    }
}
