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
        Schema::create('cashiers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift_id');
            $table->integer('employee_id');
            $table->decimal('papers_total', 20,2)->nullable();
            $table->decimal('coins_total', 20,2)->nullable();
            $table->decimal('total', 20,2)->nullable();
            $table->json('papers_qty')->nullable();
            $table->json('coins_qty')->nullable();
            $table->decimal('end_papers_total', 20,2)->nullable();
            $table->decimal('end_coins_total', 20,2)->nullable();
            $table->decimal('end_total', 20,2)->nullable();
            $table->json('end_papers_qty')->nullable();
            $table->json('end_coins_qty')->nullable();
            $table->boolean('opened');
            $table->boolean('closed');
            $table->boolean('ownered');
            $table->text('description')->nullable();
            $table->timestamps();

            // shift_id foreign tbl:shifts 
            $table->foreign('shift_id')
                  ->references('id')->on('shifts');

            // employee_id foreign tbl:employees 
            $table->foreign('employee_id')
                  ->references('id')->on('employees');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cashiers');
    }
};