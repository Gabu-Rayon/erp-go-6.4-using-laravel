<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    protected $fillable = [
        'warehouse_id',
        'itemCd',
        'product_id',
        'quantity',
        'packageQuantity',
        'created_by',
    ];


    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id');
    }
    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'from_warehouse');
    }

}