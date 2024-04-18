<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompositionItem extends Model
{
    protected $fillable = ['compoItemCode', 'compoItemQty'];

    public function mainItem()
    {
        return $this->belongsTo(MainItem::class);
    }
}