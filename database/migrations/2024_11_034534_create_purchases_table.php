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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id')->nullable();
            $table->foreignId('vender_id')->nullable();
            $table->foreignId('warehouse_id')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('purchase_number')->nullable();
            $table->integer('status')->nullable();
            $table->integer('shipping_display')->nullable();
            $table->date('send_date')->nullable();
            $table->integer('discount_apply')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('spplrTin')->nullable();
            $table->string('spplrNm')->nullable();
            $table->string('spplrBhfId')->nullable();
            $table->string('spplrInvcNo')->nullable();
            $table->string('spplrSdcId')->nullable();
            $table->string('spplrMrcNo')->nullable();
            $table->string('rcptTyCd')->nullable();
            $table->string('pmtTyCd')->nullable();
            $table->date('cfmDt')->nullable();
            $table->date('salesDt')->nullable();
            $table->date('stockRlsDt')->nullable();
            $table->integer('totItemCnt')->nullable();
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
            $table->boolean('isDbImport')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};