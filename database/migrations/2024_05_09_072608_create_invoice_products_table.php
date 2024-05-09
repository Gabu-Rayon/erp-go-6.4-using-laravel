<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'invoice_products',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('invoice_id');
                $table->integer('product_id');
                $table->integer('quantity');
                $table->string('tax', '50')->nullable();
                $table->float('discount')->default('0.00');
                $table->decimal('price', 16, 2)->default('0.0');
                $table->text('description')->nullable();
                
                $table->bigInteger('customer_id')->nullable();
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
                $table->decimal('discountRate', 10, 2);
                $table->decimal('discountAmt', 10, 2);
                $table->string('itemExprDate');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_products');
    }
}