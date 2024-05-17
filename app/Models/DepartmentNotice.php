<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentNotice extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'notice',
        'given_by',
        'department',
    ];


}
