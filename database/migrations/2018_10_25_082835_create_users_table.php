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
            $table->integer('employee_id')->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->timestamp('last_login')->nullable();
            $table->ipAddress('last_ip_address', 20)->nullable();
            $table->boolean('is_logged')->nullable();
            $table->boolean('is_owner');
            $table->timestamps();
            $table->rememberToken();

            // identity_id foreign tbl:employees 
            $table->foreign('employee_id')
                  ->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
