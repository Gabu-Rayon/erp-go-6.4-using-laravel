<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->string('tax', '50')->nullable();
            $table->float('discount')->default('0.00');
            $table->decimal('price', 15, 2)->nullable()->default(0.0);
            $table->text('description')->nullable();


            $table->string('saleItemCode')->nullable();
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
            $table->date('itemExprDt')->nullable();
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
        Schema::dropIfExists('purchase_products');
    }
}