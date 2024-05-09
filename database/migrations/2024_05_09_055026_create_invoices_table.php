<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('send_date')->nullable();
            $table->integer('category_id');
            $table->text('ref_number')->nullable();
            $table->integer('status')->default(0);
            $table->integer('shipping_display')->default(1);
            $table->integer('discount_apply')->default(0);
            $table->integer('created_by')->default(0);
            // Extra fields from the JSON
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
            $table->json('invoiceStatusCode')->nullable();           
            $table->boolean('remark')->default(false);
            $table->boolean('isPurchaseAccept')->default(false);
            $table->boolean('isStockIOUpdate')->default(false);
            $table->string('mapping')->nullable();
            //for Api Response after posting an sales to create an invoice  
            $table->string('invoiceNo')->nullable();
            $table->string('tranderInvoiceNo')->nullable();
            $table->string('scuInternalData')->nullable();
            $table->string('scuReceiptSignature')->nullable();
            $table->string('sdcid')->nullable();
            $table->string('sdcmrcNo')->nullable();
            $table->string('sdcDateTime')->nullable();
            $table->string('scuqrCode')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}