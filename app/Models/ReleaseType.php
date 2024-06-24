<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseType extends Model
{
    use HasFactory;

    protected $table = 'stock_release_types';
    protected $fillable = [
        'code',
        'type',
    ];
}
