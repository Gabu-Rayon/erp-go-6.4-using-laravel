<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTypeCodes extends Model
{
    use HasFactory;
    protected $table = 'purchase_types_code';
    protected $fillable = ['purchase_type_code'];
}