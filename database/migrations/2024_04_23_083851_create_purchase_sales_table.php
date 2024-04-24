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
            $table->string('spplrTin');
            $table->string('spplrNm');
            $table->string('spplrBhfId');
            $table->string('spplrInvcNo');
            $table->string('spplrSdcId');
            $table->string('spplrMrcNo');
            $table->string('rcptTyCd');
            $table->string('pmtTyCd');
            $table->date('cfmDt');
            $table->date('salesDt');
            $table->date('stockRlsDt');
            $table->integer('totItemCnt');
            $table->decimal('taxblAmtA', 8, 2);
            $table->decimal('taxblAmtB', 8, 2);
            $table->decimal('taxblAmtC', 8, 2);
            $table->decimal('taxblAmtD', 8, 2);
            $table->decimal('taxblAmtE', 8, 2);
            $table->integer('taxRtA');
            $table->integer('taxRtB');
            $table->integer('taxRtC');
            $table->integer('taxRtD');
            $table->integer('taxRtE');
            $table->decimal('taxAmtA', 8, 2);
            $table->decimal('taxAmtB', 8, 2);
            $table->decimal('taxAmtC', 8, 2);
            $table->decimal('taxAmtD', 8, 2);
            $table->decimal('taxAmtE', 8, 2);
            $table->decimal('totTaxblAmt', 8, 2);
            $table->decimal('totTaxAmt', 8, 2);
            $table->decimal('totAmt', 8, 2);
            $table->string('remark');
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