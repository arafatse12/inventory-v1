<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->enum('stock_type', ['Recipte','Transfer']);
            $table->enum('is_opening',['Yes','No'])->default('No');
            $table->date('posting_date_time')->default(now());
            $table->date('stock_date');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->enum('stock_transcation', ['In','Out'])->comment("In and Out");
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
        });
        Schema::create('stock_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->integer('amount');
            $table->integer('purchase_price');
            $table->integer('sell_price');
            $table->integer('markup')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('stock_details');
    }
}
