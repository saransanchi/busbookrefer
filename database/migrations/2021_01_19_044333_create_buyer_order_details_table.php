<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buyer_order_id')->unsigned();
            $table->foreign('buyer_order_id')->references('id')->on('buyer_orders');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('quantity');
            $table->double('unit_price');
            $table->double('total_price');
            $table->double('wastage')->nullable();
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
        Schema::dropIfExists('buyer_order_details');
    }
}
