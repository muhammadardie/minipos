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
        Schema::create('cashier_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cashier_id');
            $table->integer('customer_id')->nullable();
            $table->string('invoice', 30); // 18.11.00028
            $table->decimal('bill_amount', 20,2);
            $table->decimal('pay_amount', 20,2);
            $table->decimal('change', 20,2)->nullable();
            $table->decimal('discount', 20,2)->nullable();
            $table->string('email_receipt', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamps();

            // cashier_id foreign tbl:cashiers 
            $table->foreign('cashier_id')
                  ->references('id')->on('cashiers');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_transactions');
    }
};