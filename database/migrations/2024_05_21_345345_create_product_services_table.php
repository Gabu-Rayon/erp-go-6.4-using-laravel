<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
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
            $table->string('sku')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('sale_chartaccount_id')->nullable();
            $table->unsignedBigInteger('expense_chartaccount_id')->nullable();
            $table->string('pro_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('tin')->nullable();
            $table->string('itemCd')->nullable();
            $table->string('itemClsCd')->nullable();
            $table->string('itemTyCd')->nullable();
            $table->string('itemNm')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('itemStdNm')->nullable();
            $table->string('orgnNatCd')->nullable();
            $table->string('pkgUnitCd')->nullable();
            $table->string('qtyUnitCd')->nullable();
            $table->string('taxTyCd')->nullable();
            $table->string('btchNo')->nullable();
            $table->string('regBhfId')->nullable();
            $table->string('bcd')->nullable();
            $table->decimal('dftPrc', 10, 2)->nullable();
            $table->decimal('grpPrcL1', 10, 2)->nullable();
            $table->decimal('grpPrcL2', 10, 2)->nullable();
            $table->decimal('grpPrcL3', 10, 2)->nullable();
            $table->decimal('grpPrcL4', 10, 2)->nullable();
            $table->decimal('grpPrcL5', 10, 2)->nullable();
            $table->integer('sftyQty')->nullable();
            $table->integer('packageQuantity')->nullable();
            $table->text('addInfo')->nullable();
            $table->boolean('isrcAplcbYn')->nullable();
            $table->boolean('rraModYn')->nullable();
            $table->boolean('useYn')->nullable();
            $table->boolean('isUsed')->nullable();
            $table->string('kraItemCode')->nullable();
            $table->boolean('isKRASync')->nullable();
            $table->boolean('isStockIO')->nullable();


            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('taxTyCd')->references('cd')->on('details');
            $table->foreign('itemClsCd')->references('itemClsCd')->on('productservices_classifications');

            $table->timestamps();

            // Foreign keys
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('sale_chartaccount_id')->references('id')->on('chart_accounts')->onDelete('set null');
            $table->foreign('expense_chartaccount_id')->references('id')->on('chart_accounts')->onDelete('set null');
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
};