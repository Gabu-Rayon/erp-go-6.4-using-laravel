<?php
// app/Models/StockAdjustment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $table = 'stock_adjustments';

    protected $fillable = [
        'storeReleaseTypeCode',
        'remark',
        'rsdQty',
    ];

    public function stockAdjustmentProductLists()
    {
        return $this->hasMany(StockAdjustmentProductList::class, 'stock_adjustments_id', 'id');
    }
}