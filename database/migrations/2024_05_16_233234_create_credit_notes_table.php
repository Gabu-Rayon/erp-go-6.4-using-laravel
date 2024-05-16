<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'credit_notes',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('invoice')->default('0')->nullable();
                $table->integer('orgInvoiceNo')->nullable();
                $table->string('customerTin')->nullable();
                $table->integer('customer')->default('0')->nullable();
                $table->string('customerName')->nullable();
                $table->string('salesType')->nullable();
                $table->string('paymentType')->nullable();
                $table->string('creditNoteReason')->nullable()->nullable();
                $table->string('creditNoteDate')->nullable();
                $table->string('traderInvoiceNo')->nullable();
                $table->string('confirmDate')->nullable();
                $table->string('salesDate')->nullable();
                $table->string('stockReleseDate')->nullable();
                $table->string('receiptPublishDate')->nullable();
                $table->string('occurredDate')->nullable();
                $table->string('invoiceStatusCode')->nullable();
                $table->string('remark')->nullable();
                $table->boolean('isPurchaseAccept')->nullable();
                $table->boolean('isStockIOUpdate')->nullable();
                $table->string('mapping')->nullable();
                $table->decimal('amount', 15, 2)->default('0.00')->nullable();
                $table->string('response_invoiceNo')->nullable();
                $table->string('response_tranderInvoiceNo')->nullable();
                $table->string('response_scuInternalData')->nullable();
                $table->string('response_scuReceiptSignature')->nullable();
                $table->string('response_sdcid')->nullable();
                $table->string('response_sdcmrcNo')->nullable();
                $table->string('response_sdcDateTime')->nullable();
                $table->string('response_scuqrCode')->nullable();
                $table->boolean('response_isStockIOUpdate')->nullable();
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
        Schema::dropIfExists('credit_notes');
    }
}