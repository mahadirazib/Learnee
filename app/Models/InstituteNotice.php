<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteNotice extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',
        'notice',
        'given_by',
        'institute',
    ];


}
