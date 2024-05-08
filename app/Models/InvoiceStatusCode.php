<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatusCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoiceStatusCode',
        'invoiceStatusValue'
    ];
}
