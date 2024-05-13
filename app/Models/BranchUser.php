<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'branchUserId',
        'branchUserName',
        "password",
        "address",
        "contactNo",
        "authenticationCode",
        "remark",
        "isUsed",
        "created_by"
    ];
}
