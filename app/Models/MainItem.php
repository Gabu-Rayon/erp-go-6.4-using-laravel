<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainItem extends Model
{
    protected $fillable = ['mainItemCode'];

    public function compositionItems()
    {
        return $this->hasMany(CompositionItem::class);
    }
}