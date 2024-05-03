<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCreditNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'orgInvoiceNo',
        'customerTin',
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
    ];
}
