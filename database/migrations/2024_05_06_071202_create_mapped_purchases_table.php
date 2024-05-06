<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mapped_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('mappedPurchaseId')->nullable();
            $table->integer('invcNo')->nullable();
            $table->integer('orgInvcNo')->default(0)->nullable();
            $table->string('supplrTin')->nullable();
            $table->string('supplrBhfId')->nullable();
            $table->string('supplrName')->nullable();
            $table->string('supplrInvcNo')->nullable();
            $table->string('purchaseTypeCode')->nullable();
            $table->string('rceiptTyCd')->nullable();
            $table->string('paymentTypeCode')->nullable();
            $table->string('purchaseSttsCd')->nullable();
            $table->dateTime('confirmDate')->nullable();
            $table->date('purchaseDate')->nullable();
            $table->dateTime('warehouseDt')->nullable();
            $table->dateTime('cnclReqDt')->nullable();
            $table->dateTime('cnclDt')->nullable();
            $table->dateTime('refundDate')->nullable();
            $table->integer('totItemCnt')->nullable();
            $table->decimal('taxblAmtA', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxblAmtB', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxblAmtC', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxblAmtD', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxRtA', 5, 2)->default(0.00)->nullable();
            $table->decimal('taxRtB', 5, 2)->default(0.00)->nullable();
            $table->decimal('taxRtC', 5, 2)->default(0.00)->nullable();
            $table->decimal('taxRtD', 5, 2)->default(0.00)->nullable();
            $table->decimal('taxAmtA', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxAmtB', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxAmtC', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('taxAmtD', 18, 8)->default(0.00000000)->nullable();
            $table->decimal('totTaxblAmt', 18, 8)->nullable();
            $table->decimal('totTaxAmt', 18, 8)->nullable();
            $table->decimal('totAmt', 18, 8)->nullable();
            $table->string('remark')->nullable();
            $table->dateTime('resultDt')->nullable();
            $table->dateTime('createdDate')->nullable();
            $table->boolean('isUpload')->nullable();
            $table->boolean('isStockIOUpdate')->nullable();
            $table->boolean('isClientStockUpdate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapped_purchases');
    }
};