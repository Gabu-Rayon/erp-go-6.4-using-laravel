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
        Schema::create('imported_items', function (Blueprint $table) {
            $table->bigIncrements('id');  // Primary key
            $table->string('srNo')->nullable();
            $table->string('taskCode')->nullable();
            $table->string('itemName')->nullable();
            $table->string('hsCode')->nullable();
            $table->string('pkgUnitCode')->nullable();
            $table->string('netWeight')->nullable();
            $table->string('invForCode')->nullable();
            $table->string('declarationDate')->nullable();
            $table->string('orginNationCode')->nullable();
            $table->string('qty')->nullable();
            $table->string('supplierName')->nullable();
            $table->string('nvcFcurExcrt')->nullable();
            $table->string('itemSeq')->nullable();
            $table->string('exprtNatCode')->nullable();
            $table->string('qtyUnitCode')->nullable();
            $table->string('agentName')->nullable();
            $table->string('declarationNo')->nullable();
            $table->string('package')->nullable();
            $table->string('grossWeight')->nullable();
            $table->string('invForCurrencyAmount')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('mapped_product_id')->nullable();
            $table->timestamp('mapped_date')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imported_items');
    }
};