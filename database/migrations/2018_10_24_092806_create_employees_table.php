<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identity_id');
            $table->integer('outlet_id')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('email', 30);
            $table->char('gender', 1);
            $table->char('marital_status', 1);
            $table->string('address', 255)->nullable();
            $table->string('identity_no', 30)->nullable();
            $table->string('mobile_phone', 30)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('remark', 255)->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_deleted')->nullable();

            // identity_id foreign tbl:identity 
            $table->foreign('identity_id')
                  ->references('id')->on('identities');

            // outlet_id foreign tbl:outlets 
            $table->foreign('outlet_id')
                  ->references('id')->on('outlets');

            // user_deleted foreign tbl:employees 
            $table->foreign('user_deleted')
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
        Schema::dropIfExists('employees');
    }
}
