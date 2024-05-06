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
        Schema::create('mapped_purchase_item_lists', function (Blueprint $table) {
             $table->id();             
             $table->integer('purchase_item_list_id')->nullable();
            $table->foreignId('mapped_purchase_id')->nullable();
            $table->integer('itemSeq')->nullable();
            $table->string('itemCd')->nullable();
            $table->string('itemClsCd')->nullable();
            $table->string('itemNmme')->nullable();
            $table->string('bcd')->nullable();
            $table->string('supplrItemClsCd')->nullable();
            $table->string('supplrItemCd')->nullable();
            $table->string('supplrItemNm')->nullable();
            $table->string('pkgUnitCd')->nullable();
            $table->decimal('pkg', 10, 8)->nullable();
            $table->string('qtyUnitCd')->nullable();
            $table->decimal('qty', 10, 8)->nullable();
            $table->decimal('unitprice', 18, 8)->nullable();
            $table->decimal('supplyAmt', 18, 8)->nullable();
            $table->decimal('discountRate', 18, 8)->nullable();
            $table->decimal('discountAmt', 18, 8)->nullable();
            $table->decimal('taxblAmt', 18, 8)->nullable();
            $table->string('taxTyCd')->nullable();
            $table->decimal('taxAmt', 18, 8)->nullable();
            $table->decimal('totAmt', 18, 8)->nullable();
            $table->string('itemExprDt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapped_purchase_item_lists');
    }
};