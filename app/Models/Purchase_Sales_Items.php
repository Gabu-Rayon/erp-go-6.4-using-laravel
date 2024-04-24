<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Sales_Items extends Model
{
    use HasFactory;

    protected $table = 'purchase_sales_items'; // Correct table name
    protected $fillable = [     
        'itemSeq',
        'itemCd',
        'itemClsCd',
        'itemNm',
        'bcd',
        'spplrItemClsCd',
        'spplrItemCd',
        'spplrItemNm',
        'pkgUnitCd',
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
        'saleItemCode'
    ];

}