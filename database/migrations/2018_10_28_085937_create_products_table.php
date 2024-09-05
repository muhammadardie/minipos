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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->integer('product_category_id');
            $table->integer('unit_id');
            $table->integer('supplier_id');
            $table->string('name', 150);
            $table->string('code', 30);
            $table->decimal('cost', 20,2);
            $table->integer('stock')->nullable();
            $table->date('release_date');
            $table->decimal('price', 20,2);
            $table->string('storage', 255);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_deleted')->nullable();

            // product_category_id foreign tbl:product_categories 
            $table->foreign('product_category_id')
                  ->references('id')->on('product_categories');

            // unit_id foreign tbl:units 
            $table->foreign('unit_id')
                  ->references('id')->on('units');

            // supplier_id foreign tbl:suppliers 
            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers');

             // user_deleted foreign tbl:employees 
            $table->foreign('user_deleted')
                  ->references('id')->on('employees');

            // user_deleted foreign tbl:employees 
            $table->foreign('brand_id')
                  ->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};