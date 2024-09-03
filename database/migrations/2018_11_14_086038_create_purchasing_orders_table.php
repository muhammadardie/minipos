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
        Schema::create('purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_number', 30);
            $table->integer('employee_id');
            $table->integer('supplier_id');
            $table->decimal('total', 20,7)->nullable();
            $table->boolean('approved')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('purchasing_orders');
    }
};
