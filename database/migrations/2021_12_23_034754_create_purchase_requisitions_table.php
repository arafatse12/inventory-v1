<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->text('remark');
            $table->enum('status',["Pending","Approved","Cancel"]);
            $table->date('date');
            $table->unsignedBigInteger('office_id');
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            
        });
        
        Schema::create('purchase_requisition_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_requisition_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->integer('amount');
            $table->timestamps();
            $table->foreign('purchase_requisition_id')->references('id')->on('purchase_requisitions')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_requisitions');
        Schema::dropIfExists('purchase_requisition_products');
    }
}
