<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseStatusCodes extends Model
{
    use HasFactory;
    protected $table = 'purchase_status_codes';
    protected $fillable = ['purchase_status_code'];
}