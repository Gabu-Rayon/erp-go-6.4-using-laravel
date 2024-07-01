<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id')->default(0)->nullable();
            $table->integer('product_id')->default(0)->nullable();
            $table->string('itemCd');
            $table->integer('quantity')->default('0')->nullable();            
            $table->integer('packageQuantity')->default('0')->nullable();
            $table->integer('created_by')->default('0')->nullable();
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
        Schema::dropIfExists('warehouse_products');
    }
}