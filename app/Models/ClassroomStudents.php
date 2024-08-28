<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomStudents extends Model
{
    use HasFactory;

    protected $fillable = [
        'student',
        'institute',
        'department',
        'classroom',
        'passkey_upon_joining'
    ];

    protected $unique = [['student', 'classroom']];

}
