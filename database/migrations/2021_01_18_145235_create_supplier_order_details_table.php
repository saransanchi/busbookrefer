<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('supplier_order_id')->unsigned();
            $table->foreign('supplier_order_id')->references('id')->on('supplier_orders');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('retail_price');
            $table->double('agreed_quantity');
            $table->double('delivered_quantity');
            $table->double('wastage_quantity')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_order_details');
    }
}
