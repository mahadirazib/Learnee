<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentStudents extends Model
{
    use HasFactory;



    protected $fillable = [
        'student',
        'department',
        'passkey_upon_joining'
    ];


    protected $unique = [['student', 'department']];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(InstituteDepartment::class);
    }



}
