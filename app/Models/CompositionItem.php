<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompositionItem extends Model
{
    protected $table = 'composition_items';
    protected $fillable = [
        'mainItemCode',
        'compoItemCode',
        'compoItemQty'
    ];
}
