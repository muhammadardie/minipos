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
        Schema::create('purchasing_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchasing_order_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->decimal('total', 20,7);
            $table->timestamps();

            // purchasing_order_id foreign tbl:purchasing_orders 
            $table->foreign('purchasing_order_id')
                  ->references('id')->on('purchasing_orders')
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
        Schema::dropIfExists('purchasing_order_details');
    }
};