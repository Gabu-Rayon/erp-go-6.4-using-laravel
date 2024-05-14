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
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('sale_price', 16, 2)->default('0.0')->nullable();
            $table->decimal('purchase_price', 16, 2)->default('0.0')->nullable();
            $table->float('quantity')->default('0.0')->nullable();
            $table->string('tax_id','50')->nullable();
            $table->integer('category_id')->default('0');
            $table->integer('unit_id')->default('0')->nullable();
            $table->string('type')->nullable();
            $table->integer('sale_chartaccount_id')->default('0')->nullable();
            $table->integer('expense_chartaccount_id')->default('0')->nullable();
            $table->text('description')->nullable();
            $table->string('pro_image')->nullable();
            $table->integer('created_by')->default('0');
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
            $table->double('dftPrc')->nullable();
            $table->double('grpPrcL1')->nullable();
            $table->double('grpPrcL2')->nullable();
            $table->double('grpPrcL3')->nullable();
            $table->double('grpPrcL4')->nullable();
            $table->double('grpPrcL5')->nullable();
            $table->string('addInfo')->nullable();
            $table->integer('sftyQty')->nullable();
            $table->string('isrcAplcbYn')->nullable();
            $table->string('rraModYn')->nullable();
            $table->string('useYn')->nullable();
            $table->index('itemCd')->nullable();
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