<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Sales extends Model
{
    use HasFactory;


    protected $table = 'purchase_sales'; // Correct table name
    protected $fillable = [
        'spplrTin',
        'spplrNm',
        'spplrBhfId',
        'spplrInvcNo',
        'spplrSdcId',
        'spplrMrcNo',
        'rcptTyCd',
        'pmtTyCd',
        'cfmDt',
        'salesDt',
        'stockRlsDt',
        'totItemCnt',
        'taxblAmtA',
        'taxblAmtB',
        'taxblAmtC',
        'taxblAmtD',
        'taxblAmtE',
        'taxRtA',
        'taxRtB',
        'taxRtC',
        'taxRtD',
        'taxRtE',
        'taxAmtA',
        'taxAmtB',
        'taxAmtC',
        'taxAmtD',
        'taxAmtE',
        'totTaxblAmt',
        'totTaxAmt',
        'totAmt',
        'remark',
    ];
}