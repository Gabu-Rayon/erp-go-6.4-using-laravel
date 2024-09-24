<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchTransferProduct extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'branch_transfer_products';

    // Define the fillable attributes
    protected $fillable = [
        'itemCode',
        'quantity',
        'pkgQuantity',
        'branch_transfer_id',
    ];

    // Define the relationship with BranchTransfer
    public function branchTransfer()
    {
        return $this->belongsTo(BranchTransfer::class, 'branch_transfer_id');
    }
}