<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
     protected $fillable = [
        'invoice',
        'orgInvoiceNo',
        'customerTin',
        'customer',
        'customerName',
        'salesType',
        'paymentType',
        'creditNoteReason',
        'creditNoteDate',
        'traderInvoiceNo',
        'confirmDate',
        'salesDate',
        'stockReleseDate',
        'receiptPublishDate',
        'occurredDate',
        'invoiceStatusCode',
        'remark',
        'isPurchaseAccept',
        'isStockIOUpdate',
        'mapping',
        'amount',
        'response_invoiceNo',
        'response_tranderInvoiceNo',
        'response_scuInternalData',
        'response_scuReceiptSignature',
        'response_sdcid',
        'response_sdcmrcNo',
        'response_sdcDateTime',
        'response_scuqrCode',
        'response_isStockIOUpdate'
    ];

    protected $table = 'credit_notes';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer', 'customer_id');
    }

}