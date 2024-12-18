<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';
    protected $fillable = [
        'noticeNo',
        'title',
        'cont',
        'dtlUrl',
        'regrNm',
        'regDt'
    ];
}