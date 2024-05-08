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
        $table->string('trderInvoiceNo')->nullable();
        $table->integer('invoiceNo')->nullable();
        $table->integer('orgInvoiceNo')->nullable();
        $table->string('customerTin')->nullable();
        $table->string('customerName')->nullable();
        $table->string('receptTypeCode')->nullable();
        $table->string('paymentTypeCode')->nullable();
        $table->string('salesSttsCode')->nullable();
        $table->dateTime('confirmDate')->nullable();
        $table->date('salesDate')->nullable();
        $table->dateTime('stockReleaseDate')->nullable();
        $table->dateTime('cancelReqDate')->nullable();
        $table->dateTime('cancelDate')->nullable();
        $table->dateTime('refundDate')->nullable();
        $table->string('refundReasonCd')->nullable();
        $table->integer('totalItemCnt')->nullable();
        $table->decimal('taxableAmtA', 15, 2)->nullable();
        $table->decimal('taxableAmtB', 15, 2)->nullable();
        $table->decimal('taxableAmtC', 15, 2)->nullable();
        $table->decimal('taxableAmtD', 15, 2)->nullable();
        $table->decimal('taxRateA', 15, 2)->nullable();
        $table->decimal('taxRateB', 15, 2)->nullable();
        $table->decimal('taxRateC', 15, 2)->nullable();
        $table->decimal('taxRateD', 15, 2)->nullable();
        $table->decimal('taxAmtA', 15, 2)->nullable();
        $table->decimal('taxAmtB', 15, 2)->nullable();
        $table->decimal('taxAmtC', 15, 2)->nullable();
        $table->decimal('taxAmtD', 15, 2)->nullable();
        $table->decimal('totalTaxableAmt', 15, 2)->nullable();
        $table->decimal('totalTaxAmt', 15, 2)->nullable();
        $table->decimal('totalAmt', 15, 2)->nullable();
        $table->string('prchrAcptcYn')->nullable();
        $table->string('remark')->nullable();
        $table->string('regrNm')->nullable();
        $table->string('regrId')->nullable();
        $table->string('modrNm')->nullable();
        $table->string('modrId')->nullable();
        $table->string('receipt_CustomerTin')->nullable();
        $table->string('receipt_CustomerMblNo')->nullable();
        $table->string('receipt_RptNo')->nullable();
        $table->dateTime('receipt_RcptPbctDt')->nullable();
        $table->string('receipt_TrdeNm')->nullable();
        $table->string('receipt_Adrs')->nullable();
        $table->string('receipt_TopMsg')->nullable();
        $table->string('receipt_BtmMsg')->nullable();
        $table->string('receipt_PrchrAcptcYn')->nullable();
        $table->dateTime('createdDate')->nullable();
        $table->boolean('isKRASynchronized')->nullable();
        $table->dateTime('kraSynchronizedDate')->nullable();
        $table->boolean('isStockIOUpdate')->nullable();
        $table->string('resultCd')->nullable();
        $table->string('resultMsg')->nullable();
        $table->dateTime('resultDt')->nullable();
        $table->integer('response_CurRcptNo')->nullable();
        $table->integer('response_TotRcptNo')->nullable();
        $table->string('response_IntrlData')->nullable();
        $table->string('response_RcptSign')->nullable();
        $table->dateTime('response_SdcDateTime')->nullable();
        $table->string('response_SdcId')->nullable();
        $table->string('response_MrcNo')->nullable();
        $table->string('qrCodeURL')->nullable();
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