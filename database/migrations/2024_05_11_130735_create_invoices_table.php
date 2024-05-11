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
            $table->id();
            $table->string('invoice_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('send_date')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('ref_number')->nullable();
            $table->unsignedBigInteger('status')->default(0);
            $table->unsignedBigInteger('shipping_display')->nullable();
            $table->unsignedBigInteger('discount_apply')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('trderInvoiceNo');
            $table->string('invoiceNo');
            $table->string('orgInvoiceNo');
            $table->string('customerTin');
            $table->string('customerName');
            $table->unsignedBigInteger('receptTypeCode')->nullable();
            $table->unsignedBigInteger('paymentTypeCode')->nullable();
            $table->unsignedBigInteger('salesSttsCode')->nullable();
            $table->date('confirmDate');
            $table->date('salesDate');
            $table->date('stockReleaseDate');
            $table->date('cancelReqDate')->nullable();
            $table->date('cancelDate')->nullable();
            $table->date('refundDate')->nullable();
            $table->unsignedBigInteger('refundReasonCd')->nullable();
            $table->unsignedBigInteger('totalItemCnt')->nullable();
            $table->decimal('taxableAmtA', 10, 2)->nullable();
            $table->decimal('taxableAmtB', 10, 2)->nullable();
            $table->decimal('taxableAmtC', 10, 2)->nullable();
            $table->decimal('taxableAmtD', 10, 2)->nullable();
            $table->decimal('taxRateA', 10, 2)->nullable();
            $table->decimal('taxRateB', 10, 2)->nullable();
            $table->decimal('taxRateC', 10, 2)->nullable();
            $table->decimal('taxRateD', 10, 2)->nullable();
            $table->decimal('taxAmtA', 10, 2)->nullable();
            $table->decimal('taxAmtB', 10, 2)->nullable();
            $table->decimal('taxAmtC', 10, 2)->nullable();
            $table->decimal('taxAmtD', 10, 2)->nullable();
            $table->decimal('totalTaxableAmt', 10, 2)->nullable();
            $table->decimal('totalTaxAmt', 10, 2)->nullable();
            $table->decimal('totalAmt', 10, 2);
            $table->unsignedBigInteger('prchrAcptcYn')->nullable();
            $table->text('remark')->nullable();
            $table->string('regrNm')->nullable();
            $table->unsignedBigInteger('regrId')->nullable();
            $table->string('modrNm')->nullable();
            $table->unsignedBigInteger('modrId')->nullable();
            $table->string('receipt_CustomerTin')->nullable();
            $table->string('receipt_CustomerMblNo')->nullable();
            $table->string('receipt_RptNo')->nullable();
            $table->date('receipt_RcptPbctDt')->nullable();
            $table->string('receipt_TrdeNm')->nullable();
            $table->string('receipt_Adrs')->nullable();
            $table->text('receipt_TopMsg')->nullable();
            $table->text('receipt_BtmMsg')->nullable();
            $table->unsignedBigInteger('receipt_PrchrAcptcYn')->nullable();
            $table->date('createdDate')->nullable();
            $table->unsignedBigInteger('isKRASynchronized')->nullable();
            $table->date('kraSynchronizedDate')->nullable();
            $table->boolean('isStockIOUpdate');
            $table->unsignedBigInteger('resultCd')->nullable();
            $table->text('resultMsg')->nullable();
            $table->date('resultDt')->nullable();
            $table->string('response_CurRcptNo')->nullable();
            $table->string('response_TotRcptNo')->nullable();
            $table->text('response_IntrlData')->nullable();
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