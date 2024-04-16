<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeListDetail extends Model
{
    use HasFactory;


    protected $fillable = [
        'code',
        'class_id',
        'codeName',
        'codeDescription',
        'useYearno',
        'srtOrder',
        'userDefineCode1',
        'userDefineCode2',
        'userDefineCode3',
    ];

    // Define the relationship with CodeList model
    public function codeListClasses()
    {
        return $this->belongsTo(CodeListClasses::class, 'class_id', 'id');
    }
}