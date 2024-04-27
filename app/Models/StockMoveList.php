<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMoveList extends Model
{
    use HasFactory;
    protected $fillable = [
        'custTin',
        'custBhfId',
        'sarNo',
        'ocrnDt',
        'totItemCnt',
        'totTaxblAmt',
        'totTaxAmt',
        'totAmt',
        'status',
        'remark'
    ];
}
