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
        Schema::create('cashier_transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cashier_transaction_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->decimal('discount', 20,7)->nullable();
            $table->decimal('total', 20,7);
            $table->timestamps();

            // cashier_transaction_id foreign tbl:cashier_transactions 
            $table->foreign('cashier_transaction_id')
                  ->references('id')->on('cashier_transactions')
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
        Schema::dropIfExists('cashier_transaction_details');
    }
};