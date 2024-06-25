<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductServiceUnit extends Model
{
    use HasFactory;

    protected $table = 'product_service_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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