<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptTypeCodes extends Model
{
    use HasFactory;

    protected $table = 'receipt_types_code';
    protected $fillable = ['receipt_type_code'];
}