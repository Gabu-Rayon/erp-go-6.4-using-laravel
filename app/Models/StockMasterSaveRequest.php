<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasterSaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "itemCd",
        "rsdQty",
        "regrId",
        "regrNm",
        "modrNm",
        "modrId",
        "tin",
        "bhfId"
    ];
}
