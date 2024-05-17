<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteFaculties extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty',
        'institute',
        'passkey_upon_joining'
    ];


    protected $unique = [['faculty', 'institute']];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    
}
