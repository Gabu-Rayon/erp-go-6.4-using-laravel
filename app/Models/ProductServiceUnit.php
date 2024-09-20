<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductServiceUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'mapping',
        'remark',
        'created_by',
        'status',
    ];
}