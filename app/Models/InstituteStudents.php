<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteStudents extends Model
{
    use HasFactory;

    protected $fillable = [
        'student',
        'institute',
        'passkey_upon_joining'
    ];


    protected $unique = [['student', 'institute']];
}
