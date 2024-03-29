<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
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
            $table->boolean('sessionY')->default(0);
            $table->boolean('sessionG')->default(0);
            $table->boolean('sessionB')->default(0);
            $table->integer('maxStudentsPerSession')->default(30);
            $table->integer('maxTot')->nullable();
            $table->integer('signedTot')->default(0);
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
        Schema::drop('courses');
    }
}
