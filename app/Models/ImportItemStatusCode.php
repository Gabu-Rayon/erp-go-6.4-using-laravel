<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportItemStatusCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'KRA_Code'
    ];
}