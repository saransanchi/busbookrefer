<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerWastageImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_wastage_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buyer_order_details_id')->unsigned();
            $table->foreign('buyer_order_details_id')->references('id')->on('buyer_order_details');
            $table->string('img_name');
            $table->string('local_path');
            $table->string('public_path');
            $table->string('thumb_path');
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
        Schema::dropIfExists('buyer_wastage_images');
    }
}
