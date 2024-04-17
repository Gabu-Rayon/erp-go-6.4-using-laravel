<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    protected $fillable = [
        'cdCls',
        'cd',
        'cdNm',
        'cdDesc',
        'useYn',
        'srtOrd',
        'userDfnCd1',
        'userDfnCd2',
        'userDfnCd3',
    ];
}