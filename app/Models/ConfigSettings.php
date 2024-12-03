<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'local_storage',
        'stock_update',
        'customer_mapping_by_tin',
        'item_mapping_by_code',
        'api_type',
        'api_url',
        'api_key',
        'created_by'
    ];
    
}