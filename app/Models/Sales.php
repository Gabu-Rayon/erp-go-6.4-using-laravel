<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'customerName',
        'customerTin',
        'customerNo',
        'customerMobileNo',
        'salesType',
        'paymentType',
        'traderInvoiceNo',
        'confirmDate',
        'salesDate',
        'stockReleseDate',
        'receiptPublishDate',
        'occurredDate',
        'formDataObject',
        'isPurchaseAccept',
        'isStockIOUpdate',
        'mapping',
        'status',
        'remark'
    ];
}
