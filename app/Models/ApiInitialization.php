<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiInitialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'tin',
        'bhfId',
        'dvcSrlNo',
        'taxprNm',
        'bsnsActv',
        'bhfNm',
        'bhfOpenDt',
        'prvncNm',
        'dstrtNm',
        'sctrNm',
        'locDesc',
        'hqYn',
        'mgrNm',
        'mgrTelNo',
        'mgrEmail',
        'dvcId',
        'sdcId',
        'mrcNo',
        'cmcKey',
        'resultCd',
        'resultMsg',
        'resultDt'
    ];
}
