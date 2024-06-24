<?php 
// app/Models/StockAdjustmentProductList.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustmentProductList extends Model
{
    protected $table = 'stock_adjustment_product_lists';

    protected $fillable = [
        'stock_adjustments_id',
        'itemCode',
        'packageQuantity',
        'quantity',
    ];

    public function stockAdjustment()
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustments_id');
    }
}