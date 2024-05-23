<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'issue_date',
        'due_date',
        'send_date',
        'category_id',
        'ref_number',
        'status',
        'shipping_display',
        'discount_apply',
        'created_by',        
        'trderInvoiceNo',
        'invoiceNo',
        'orgInvoiceNo',
        'customerTin',
        'customerName',
        'receptTypeCode',
        'paymentTypeCode',
        'salesSttsCode',
        'confirmDate',
        'salesDate',
        'stockReleaseDate',
        'cancelReqDate',
        'cancelDate',
        'refundDate',
        'refundReasonCd',
        'totalItemCnt',
        'taxableAmtA',
        'taxableAmtB',
        'taxableAmtC',
        'taxableAmtD',
        'taxRateA',
        'taxRateB',
        'taxRateC',
        'taxRateD',
        'taxAmtA',
        'taxAmtB',
        'taxAmtC',
        'taxAmtD',
        'totalTaxableAmt',
        'totalTaxAmt',
        'totalAmt',
        'prchrAcptcYn',
        'remark',
        'regrNm',
        'regrId',
        'modrNm',
        'modrId',
        'receipt_CustomerTin',
        'receipt_CustomerMblNo',
        'receipt_RptNo',
        'receipt_RcptPbctDt',
        'receipt_TrdeNm',
        'receipt_Adrs',
        'receipt_TopMsg',
        'receipt_BtmMsg',
        'receipt_PrchrAcptcYn',
        'createdDate',
        'isKRASynchronized',
        'kraSynchronizedDate',
        'isStockIOUpdate',
        'resultCd',
        'resultMsg',
        'resultDt',
        'response_CurRcptNo',
        'response_TotRcptNo',
        'response_IntrlData',
        'response_RcptSign',
        'response_SdcDateTime',
        'response_SdcId',
        'response_MrcNo',
        'qrCodeURL',
    ];


    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];


    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\InvoiceProduct', 'invoice_id', 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }
    public function bankPayments()
    {
        return $this->hasMany('App\Models\InvoiceBankTransfer', 'invoice_id', 'id')->where('status','!=','Approved');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }


   

    // private static $getTotal = NULL;
    // public static function getTotal(){
    //     if(self::$getTotal == null){
    //         $Invoice = new Invoice();
    //         self::$getTotal = $Invoice->invoiceTotal();
    //     }
    //     return self::$getTotal;
    // }

    public function getTotal()
    {
        return $this->totalAmt;
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach($this->items as $product)
        {
            \Log::info('SUB TOTAL ITEM');
            \Log::info($product);
            $subTotal += ($product->unitPrice * $product->quantity * $product->pkgQuantity);
        }

        return $subTotal;
    }


    // public function getTotalTax()
    // {
    //     $totalTax = 0;
    //     foreach($this->items as $product)
    //     {
    //         $taxes = Utility::totalTaxRate($product->tax);


    //         $totalTax += ($taxes / 100) * ($product->price * $product->quantity - $product->discount) ;
    //     }

    //     return $totalTax;
    // }

    public function getTotalTax()
    {
        $taxData = Utility::getTaxData();
        $totalTax = 0;
        foreach($this->items as $product)
        {
            $taxArr = explode(',', $product->tax);
            $taxes = 0;
            foreach ($taxArr as $tax) {
                // $tax = TaxRate::find($tax);
                $taxes += !empty($taxData[$tax]['rate']) ? $taxData[$tax]['rate'] : 0;
            }

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);
        }

        return $totalTax;
    }
    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        foreach($this->items as $product)
        {
            $totalDiscount += $product->discount;
        }

        return $totalDiscount;
    }

    public function getDue()
    {
        $due = 0;
        foreach($this->payments as $payment)
        {
            $due += $payment->amount;
        }

        return ($this->getTotal() - $due) - $this->invoiceTotalCreditNote();
    }

    public static function change_status($invoice_id, $status)
    {

        $invoice         = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->update();
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function creditNote()
    {

        return $this->hasMany('App\Models\CreditNote', 'invoice', 'id');
    }

    public function invoiceTotalCreditNote()
    {
        return $this->creditNote->sum('amount');
    }

    public function lastPayments()
    {
        return $this->hasOne('App\Models\InvoicePayment', 'id', 'invoice_id');
    }

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}