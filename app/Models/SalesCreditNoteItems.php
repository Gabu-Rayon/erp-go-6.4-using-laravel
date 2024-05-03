<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCreditNoteItems extends Model
{
    use HasFactory;
    protected $fillable = [
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
}
