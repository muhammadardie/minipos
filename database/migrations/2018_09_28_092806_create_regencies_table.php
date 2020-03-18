<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id');
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_deleted')->nullable();

            // users_id foreign tbl:users 
            $table->foreign('province_id')
                  ->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regencies');
    }
}
