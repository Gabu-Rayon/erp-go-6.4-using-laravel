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
            $table->id();
            $table->string('srNo');
            $table->string('taskCode');
            $table->string('itemName');
            $table->string('hsCode');
            $table->string('pkgUnitCode');
            $table->string('netWeight');
            $table->string('invForCode');
            $table->string('declarationDate');
            $table->string('orginNationCode');
            $table->string('qty');
            $table->string('supplierName');
            $table->string('nvcFcurExcrt');
            $table->string('itemSeq');
            $table->string('exprtNatCode');
            $table->string('qtyUnitCode');
            $table->string('agentName');
            $table->string('declarationNo');
            $table->string('package');
            $table->string('grossWeight');
            $table->string('invForCurrencyAmount');
            $table->string('status')->default('pending');
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