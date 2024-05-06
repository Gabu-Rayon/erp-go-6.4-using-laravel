<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMoveListItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "stockMoveListID",
        "itemSeq",
        "itemCd",
        "itemClsCd",
        "itemNm",
        "bcd",
        "pkgUnitCd",
        "pkg",
        "qtyUnitCd",
        "qty",
        "itemExprDt",
        "prc",
        "splyAmt",
        "totDcAmt",
        "taxblAmt",
        "taxTyCd",
        "taxAmt",
        "totAmt"
    ];
}
