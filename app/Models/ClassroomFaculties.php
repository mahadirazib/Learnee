<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomFaculties extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty',
        'institute',
        'department',
        'classroom',
        'passkey_upon_joining'
    ];

    protected $unique = [['faculty', 'classroom']];
}
