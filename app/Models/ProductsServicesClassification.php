<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  ProductsServicesClassification extends Model
{
    protected $table = "productServices_classifications";
    protected $fillable = [
        'itemClsCd',
        'itemClsNm',
        'itemClsLvl',
        'taxTyCd',
        'mjrTgYn',
        'useYn'
    ];
}