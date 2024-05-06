<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappedPurchaseItemList extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_item_list_id',
        'mapped_purchase_id',
        'itemSeq',
        'itemCd',
        'itemClsCd',
        'itemNmme',
        'bcd',
        'supplrItemClsCd',
        'supplrItemCd',
        'supplrItemNm',
        'pkgUnitCd',
        'pkg',
        'qtyUnitCd',
        'qty',
        'unitprice',
        'supplyAmt',
        'discountRate',
        'discountAmt',
        'taxblAmt',
        'taxTyCd',
        'taxAmt',
        'totAmt',
        'itemExprDt',
    ];
}