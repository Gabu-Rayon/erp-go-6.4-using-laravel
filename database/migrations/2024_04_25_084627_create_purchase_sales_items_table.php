<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_sales_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('saleItemCode');
            $table->foreign('saleItemCode')->references('spplrInvcNo')->on('purchase_sales')->onDelete('cascade');
            $table->string('itemSeq')->nullable();
            $table->string('itemCd')->nullable();
            $table->string('itemClsCd')->nullable();
            $table->string('itemNm')->nullable();
            $table->string('bcd')->nullable();
            $table->string('spplrItemClsCd')->nullable();
            $table->string('spplrItemCd')->nullable();
            $table->string('spplrItemNm')->nullable();
            $table->string('pkgUnitCd')->nullable();
            $table->string('pkg')->nullable();
            $table->string('qtyUnitCd')->nullable();
            $table->string('qty')->nullable();
            $table->string('prc')->nullable();
            $table->string('splyAmt')->nullable();
            $table->string('dcRt')->nullable();
            $table->string('dcAmt')->nullable();
            $table->string('taxTyCd')->nullable();
            $table->decimal('taxblAmt', 10, 2)->nullable();
            $table->decimal('taxAmt', 10, 2)->nullable();
            $table->decimal('totAmt', 10, 2)->nullable();
            $table->string('itemExprDt')->nullable();
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