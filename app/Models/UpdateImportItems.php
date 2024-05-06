<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateImportItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'srNo',
        'taskCode',
        'declarationDate',
        'itemSeq',
        'hsCode',
        'itemClassificationCode',
        'itemCode',
        'importItemStatusCode'
    ];
}
