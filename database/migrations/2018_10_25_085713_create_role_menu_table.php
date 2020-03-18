<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->timestamps();

            // users_id foreign tbl:users 
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('cascade');

            // users_id foreign tbl:users 
            $table->foreign('menu_id')
                  ->references('id')->on('menus')
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
        Schema::dropIfExists('role_menu');
    }
}
