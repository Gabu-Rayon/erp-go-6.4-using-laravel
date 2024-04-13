<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeList extends Model
{
    use HasFactory;
    protected $fillable = [
        'codeClass',
        'codeClassName',
        'codeClassDescription',
        'useYearno',
        'userDefineName1',
        'userDefineName2',
        'userDefineName3',
    ];
}