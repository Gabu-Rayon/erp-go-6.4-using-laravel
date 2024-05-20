<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInformation extends Model
{
    use HasFactory;

    protected $table = 'item_list';

    protected $fillable = [
        'tin',
        'itemCd',
        'itemClsCd',
        'itemTyCd',
        'itemNm',
        'itemStdNm',
        'orgnNatCd',
        'pkgUnitCd',
        'qtyUnitCd',
        'taxTyCd',
        'btchNo',
        'regBhfId',
        'bcd',
        'dftPrc',
        'grpPrcL1',
        'grpPrcL2',
        'grpPrcL3',
        'grpPrcL4',
        'grpPrcL5',
        'addInfo',
        'sftyQty',
        'isrcAplcbYn',
        'rraModYn',
        'useYn',
        'image'
    ];
}