<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductServiceUnit extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'mapping',
        'status',
        'created_by',
    ];

    public function unit(){
        return $this->hasOne('App\Models\ProductService', 'unit_id', 'id');
    }  
}