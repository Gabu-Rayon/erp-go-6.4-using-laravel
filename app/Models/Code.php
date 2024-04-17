<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'code';
    protected $fillable = [
        'cdCls',
        'cdClsNm',
        'cdClsDesc',
        'useYn',
        'userDfnNm1',
        'userDfnNm2',
        'userDfnNm3',
    ];
}