<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ItemType extends Model
{
    protected $table = 'item_type';
    protected $fillable = [
        'item_type_code',
        'item_type_name'
    ];
    use HasFactory;
}
