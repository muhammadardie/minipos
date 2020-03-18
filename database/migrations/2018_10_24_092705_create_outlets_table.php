<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id');
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_deleted')->nullable();

            // users_id foreign tbl:users 
            $table->foreign('district_id')
                  ->references('id')->on('districts');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlets');
    }
}
