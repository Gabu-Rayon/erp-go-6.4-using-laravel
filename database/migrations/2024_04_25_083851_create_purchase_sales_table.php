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
        Schema::create('purchase_sales', function (Blueprint $table) {
            $table->id();
            $table->string('spplrTin')->nullable();
            $table->string('spplrNm')->nullable();
            $table->string('spplrBhfId')->nullable();
            $table->bigInteger('spplrInvcNo')->nullable();
            $table->string('spplrSdcId')->nullable();
            $table->string('spplrMrcNo')->nullable();
            $table->string('rcptTyCd')->nullable();
            $table->string('pmtTyCd')->nullable();
            $table->dateTime('cfmDt')->nullable(); 
            $table->dateTime('salesDt')->nullable(); 
            $table->dateTime('stockRlsDt')->nullable();
            $table->string('warehouseDate')->nullable();
            $table->string('warehouse')->nullable();            
            $table->string('totItemCnt')->nullable();
            $table->decimal('taxblAmtA', 10, 2)->nullable();
            $table->decimal('taxblAmtB', 10, 2)->nullable();
            $table->decimal('taxblAmtC', 10, 2)->nullable();
            $table->decimal('taxblAmtD', 10, 2)->nullable();
            $table->decimal('taxblAmtE', 10, 2)->nullable();
            $table->decimal('taxRtA', 10, 2)->nullable();
            $table->decimal('taxRtB', 10, 2)->nullable();
            $table->decimal('taxRtC', 10, 2)->nullable();
            $table->decimal('taxRtD', 10, 2)->nullable();
            $table->decimal('taxRtE', 10, 2)->nullable();
            $table->decimal('taxAmtA', 10, 2)->nullable();
            $table->decimal('taxAmtB', 10, 2)->nullable();
            $table->decimal('taxAmtC', 10, 2)->nullable();
            $table->decimal('taxAmtD', 10, 2)->nullable();
            $table->decimal('taxAmtE', 10, 2)->nullable();
            $table->decimal('totTaxblAmt', 10, 2)->nullable();
            $table->decimal('totTaxAmt', 10, 2)->nullable();
            $table->decimal('totAmt', 10, 2)->nullable(); 
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_sales');
    }
};