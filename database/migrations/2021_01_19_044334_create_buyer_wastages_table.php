<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_wastages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('wastage_quantity');
            $table->bigInteger('buyer_order_id')->unsigned();
            $table->foreign('buyer_order_id')->references('id')->on('buyer_orders');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('buyers');
            $table->binary('wastage_image');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('buyer_wastages');
    }
}
