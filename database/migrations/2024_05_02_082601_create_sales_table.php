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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->string('customerTin')->nullable();
            $table->string('customerNo')->nullable();
            $table->string('customerMobileNo')->nullable();
            $table->string('salesType')->nullable();
            $table->string('paymentType')->nullable();
            $table->string('traderInvoiceNo')->nullable();
            $table->dateTime('confirmDate')->nullable();
            $table->dateTime('salesDate')->nullable();
            $table->dateTime('stockReleseDate')->nullable();
            $table->dateTime('receiptPublishDate')->nullable();
            $table->dateTime('occurredDate')->nullable();
            $table->json('formDataObject')->nullable();
            $table->boolean('isPurchaseAccept')->default(false);
            $table->boolean('isStockIOUpdate')->default(false);
            $table->string('mapping')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
