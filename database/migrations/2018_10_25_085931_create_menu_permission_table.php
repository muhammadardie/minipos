<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_menu_id');
            $table->integer('permission_id');
            $table->timestamps();

            // users_id foreign tbl:users 
            $table->foreign('role_menu_id')
                  ->references('id')->on('role_menu')
                  ->onDelete('cascade');

            // users_id foreign tbl:users 
            $table->foreign('permission_id')
                  ->references('id')->on('permissions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_permission');
    }
};
