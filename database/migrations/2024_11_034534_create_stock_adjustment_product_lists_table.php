<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_adjustment_product_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_adjustments_id');
            $table->string('itemCode');
            $table->integer('packageQuantity');
            $table->integer('quantity');

            $table->foreign('stock_adjustments_id')->references('id')->on('stock_adjustments')->onDelete('cascade');
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
        Schema::dropIfExists('stock_adjustment_product_lists');
    }
};