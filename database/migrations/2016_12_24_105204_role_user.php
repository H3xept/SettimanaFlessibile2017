<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
        });

        Schema::table('role_user', function($table){
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');
        });

        DB::table('roles')->insert(array(
                array(
                    'name' => 'admin',
                    'display_name' => "Amministratore",
                    'level' => 10
                ),
                array(
                    'name' => 'mod',
                    'display_name' => "Moderatore",
                    'level' => 8
                ),
                array(
                    'name' => 'user',
                    'display_name' => "Utente",
                    'level' => 1
                ),
                array(
                    'name' => 'info',
                    'display_name' => "Info point",
                    'level' => 6
                )
            ));

    }

    public function down() {
        Schema::drop('role_user');
    }

}
