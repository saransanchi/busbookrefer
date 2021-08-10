<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierWastageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_wastages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('receive_quantity');
            $table->bigInteger('supplier_order_id')->unsigned();
            $table->foreign('supplier_order_id')->references('id')->on('supplier_orders');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('wastage_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_wastages');
    }
}
