<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_credit_note_id',
        'itemCode',
        'itemClassCode',
        'itemTypeCode',
        'itemName',
        'orgnNatCd',
        'taxTypeCode',
        'unitPrice',
        'isrcAplcbYn',
        'pkgUnitCode',
        'pkgQuantity',
        'qtyUnitCd',
        'quantity',
        'discountRate',
        'discountAmt',
        'itemExprDate',
    ];

    protected $table = 'credit_note_items';
}