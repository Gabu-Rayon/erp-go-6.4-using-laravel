<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $fillable = ['insuranceCode', 'insuranceName', 'premiumRate', 'isUsed','isKRASync'];
   protected  $table = 'insurances';
}