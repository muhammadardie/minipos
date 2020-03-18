<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierTransactionsTable extends Migration
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
            $table->decimal('bill_amount', 20,7);
            $table->decimal('pay_amount', 20,7);
            $table->decimal('change', 20,7)->nullable();
            $table->decimal('discount', 20,7)->nullable();
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
    public function down()
    {
        Schema::dropIfExists('cashier_transactions');
    }
}
