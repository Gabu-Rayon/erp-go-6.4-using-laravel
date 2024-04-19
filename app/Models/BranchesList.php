<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchesList extends Model
{
    use HasFactory;
    protected $fillable = [
        'tin',
        'bhfId',
        'bhfNm',
        'bhfSttsCd',
        'prvncNm',
        'dstrtNm',
        'sctrNm',
        'locDesc',
        'mgrNm',
        'mgrTelNo',
        'mgrEmail',
        'hqYn',
    ];

    protected $table = 'branches';

}