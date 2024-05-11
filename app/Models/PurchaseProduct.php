<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    protected $fillable = [
        'product_id',
        'purchase_id',
        'quantity',
        'tax',
        'discount',
        'total',
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
        'itemExprDt'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id');
    }
}