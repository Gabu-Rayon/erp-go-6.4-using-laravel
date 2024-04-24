<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Sales_Items extends Model
{
    use HasFactory;

    protected $table = 'purchase_sales_items'; // Correct table name
    protected $fillable = [
        'saleItemCode',
        'itemSeq',
        'itemCd',
        'itemClsCd',
        'itemNm',
        'bcd',
        'spplrItemClsCd',
        'spplrItemCd',
        'spplrItemNm',
        'pkgUnitCd',
        'pkg',
        'qtyUnitCd',
        'qty',
        'prc',
        'splyAmt',
        'dcRt',
        'dcAmt',
        'taxTyCd',
        'taxblAmt',
        'taxAmt',
        'totAmt',
        'itemExprDt',
    ];

}