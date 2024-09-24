<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchTransfer extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'branch_transfer';

    // Define the fillable attributes
    protected $fillable = [
        'from_branch',
        'to_branch',
        'product_id',
    ];

    // Define the relationship with BranchTransferProduct
    public function products()
    {
        return $this->hasMany(BranchTransferProduct::class, 'branch_transfer_id');
    }
}