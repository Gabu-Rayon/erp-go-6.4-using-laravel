<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompositionList extends Model
{
    use HasFactory;

    protected $table = 'composition_List';
    protected $fillable = [
        'mainItemCode',
        'compositionItems_count',
    ];
}