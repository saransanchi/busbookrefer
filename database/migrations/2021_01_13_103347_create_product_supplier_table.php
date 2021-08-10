<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_supplier', function (Blueprint $table) {
                $table->bigIncrements('id');  
                $table->bigInteger('supplier_id')->unsigned();
                $table->foreign('supplier_id')->references('id')->on('suppliers'); 
                $table->bigInteger('product_id')->unsigned();
                $table->foreign('product_id')->references('id')->on('products'); 
                $table->double('max_quantity');    
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
        Schema::dropIfExists('product_supplier');
    }
}
