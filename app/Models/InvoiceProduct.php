<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable = [
        'product_id',
        'invoice_id',
        'quantity',
        'tax',
        'discount',
        'price',
        'customer_id',
        'itemCode',
        'itemClassCode',
        'itemTypeCode',
        'itemName',
        'orgnNatCd',
        'taxTypeCode',
        'unitPrice',
        'isrcAplcbYn',
        'pkgUnitCode',
        'pkgQuantity',
        'qtyUnitCd',
        'discountRate',
        'discountAmt',
        'itemExprDate',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id');
    }


}