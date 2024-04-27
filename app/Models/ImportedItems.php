<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'srNo',
        'taskCode',
        'itemName',
        'hsCode',
        'pkgUnitCode',
        'netWeight',
        'invForCode',
        'declarationDate',
        'orginNationCode',
        'qty',
        'supplierName',
        'nvcFcurExcrt',
        'itemSeq',
        'exprtNatCode',
        'qtyUnitCode',
        'agentName',
        'declarationNo',
        'package',
        'grossWeight',
        'invForCurrencyAmount'
    ];
}
