<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_sales_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemSeq');
            $table->string('itemCd');
            $table->string('itemClsCd');
            $table->string('itemNm');
            $table->string('bcd');
            $table->string('spplrItemClsCd');
            $table->string('spplrItemCd');
            $table->string('spplrItemNm');
            $table->string('pkgUnitCd');
            $table->string('qty');
            $table->string('prc');
            $table->string('splyAmt');
            $table->string('dcRt');
            $table->string('dcAmt');
            $table->string('taxTyCd');
            $table->string('taxblAmt');
            $table->string('taxAmt');
            $table->string('totAmt');
            $table->string('itemExprDt');
            $table->foreignId('saleItemCode')->references('id')->on('purchase_sales_items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase__sales__items');
    }
};