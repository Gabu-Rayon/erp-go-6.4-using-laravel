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
            $table->string('itemCode')->unique();
            $table->string('itemClassifiCode');
            $table->string('itemTypeCode');
            $table->string('itemName');
            $table->string('itemStrdName')->nullable();
            $table->string('countryCode');
            $table->string('qtyUnitCode');
            $table->string('pkgUnitCode');
            $table->string('taxTypeCode');
            $table->string('batchNo')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('purchasePrice', 10, 2);
            $table->decimal('unitPrice', 10, 2);
            $table->decimal('group1UnitPrice', 10, 2)->nullable();
            $table->decimal('group2UnitPrice', 10, 2)->nullable();
            $table->decimal('group3UnitPrice', 10, 2)->nullable();
            $table->decimal('group4UnitPrice', 10, 2)->nullable();
            $table->decimal('group5UnitPrice', 10, 2)->nullable();
            $table->decimal('saftyQuantity', 10, 2)->nullable();
            $table->boolean('isInrcApplicable')->default(0);
            $table->boolean('isUsed')->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('packageQuantity', 10, 2)->default(0);
            $table->text('additionalInfo')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('productImage')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('taxTypeCode')->references('cd')->on('details');
            $table->foreign('itemClassifiCode')->references('itemClsCd')->on('productServices_classifications');
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
};
