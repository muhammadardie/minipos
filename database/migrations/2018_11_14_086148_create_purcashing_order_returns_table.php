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
        Schema::create('purchasing_order_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_number', 30);
            $table->integer('employee_id');
            $table->integer('purchasing_order_detail_id');
            $table->decimal('total', 20,7);
            $table->timestamps();

            // purchasing_order_id foreign tbl:purchasing_orders 
            $table->foreign('purchasing_order_detail_id')
                  ->references('id')->on('purchasing_order_details');   

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
        Schema::dropIfExists('purchasing_order_returns');
    }
};