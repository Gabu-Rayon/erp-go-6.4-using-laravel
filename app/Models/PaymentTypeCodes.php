<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypeCodes extends Model
{
    use HasFactory;

    protected $table = 'payment_types_code';
    protected $fillable = [
        'payment_type_code',
        'code'
    ];
}