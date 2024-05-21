<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('sale_chartaccount_id')->nullable();
            $table->unsignedBigInteger('expense_chartaccount_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('tin')->nullable();
            $table->string('itemCd')->nullable();
            $table->string('itemClsCd')->nullable();
            $table->string('itemTyCd')->nullable();
            $table->string('itemNm')->nullable();
            $table->string('itemStdNm')->nullable();
            $table->string('orgnNatCd')->nullable();
            $table->string('pkgUnitCd')->nullable();
            $table->string('qtyUnitCd')->nullable();
            $table->string('taxTyCd')->nullable();
            $table->string('btchNo')->nullable();
            $table->string('regBhfId')->nullable();
            $table->string('bcd')->nullable();
            $table->decimal('dftPrc', 15, 2)->nullable();
            $table->decimal('grpPrcL1', 15, 2)->nullable();
            $table->decimal('grpPrcL2', 15, 2)->nullable();
            $table->decimal('grpPrcL3', 15, 2)->nullable();
            $table->decimal('grpPrcL4', 15, 2)->nullable();
            $table->decimal('grpPrcL5', 15, 2)->nullable();
            $table->text('addInfo')->nullable();
            $table->integer('sftyQty')->nullable();
            $table->boolean('isrcAplcbYn')->default(false)->nullable();
            $table->boolean('rraModYn')->default(false)->nullable();
            $table->boolean('useYn')->default(true)->nullable();
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
        Schema::dropIfExists('product_services');
    }
}