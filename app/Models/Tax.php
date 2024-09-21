<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'rate',
        'cdCls',
        'cdNm',
        'cdDesc',
        'useYn',
        'srtord',
        'useDfnCd1',
        'useDfnCd2',
        'useDfnCd3',   
        'created_by'
    ];
}