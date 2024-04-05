<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    protected $fillable = [
        ' name',
        'alpha1_code',
        'alpha2_code',
        'alpha3_code',
        'numeric_code',
        'iso31662_code',
    ];
}