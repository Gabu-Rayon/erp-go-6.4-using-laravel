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
        Schema::create('credit_note_items', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('sales_credit_note_id');
            $table->string('itemCode');
            $table->string('itemClassCode');
            $table->string('itemTypeCode');
            $table->string('itemName');
            $table->string('orgnNatCd');
            $table->string('taxTypeCode');
            $table->decimal('unitPrice', 10, 2);
            $table->string('isrcAplcbYn');
            $table->string('pkgUnitCode');
            $table->integer('pkgQuantity');
            $table->string('qtyUnitCd');
            $table->integer('quantity');
            $table->decimal('discountRate', 10, 2);
            $table->decimal('discountAmt', 10, 2);
            $table->string('itemExprDate');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_credit_note_items');
    }
};