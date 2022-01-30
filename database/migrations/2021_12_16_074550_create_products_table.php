<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id');
            $table->string('item_code');
            $table->string('name');
            $table->enum('unit',config('enums.unit_types'));
            $table->integer('reorder_qty');
            $table->integer('max_discount');
            $table->integer('purchase_price');
            $table->integer('markup')->nullable();
            $table->integer('sell_price');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('brand_id');
            $table->integer('tax');
            $table->timestamps();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
