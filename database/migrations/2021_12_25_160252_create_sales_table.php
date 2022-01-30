<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->integer('total_amount');
            $table->integer('discount_percent');
            $table->integer('discount_amount');
            $table->integer('payment_amount');
            $table->integer('change_amount');
            $table->integer('due')->nullable();
            $table->enum('payment_mode', config('enums.sales_payment_mode'));
            $table->string('bank_name')->nullable();
            $table->integer('checque_no')->nullable();
            $table->enum('status',config('enums.sales_payment_status'));
            $table->unsignedBigInteger('office_id');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->integer('sell_amount');
            $table->integer('purchase_amount');
            $table->integer('total');
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sale_details');
    }
}
