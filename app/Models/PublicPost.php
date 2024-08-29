<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicPost extends Model
{
    use HasFactory;


    protected $fillable = [
        'user',
        'title',
        'post',
        'files'
    ];


    public function getFilesAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for files
    public function setFilesAttribute($value){
        $this->attributes['files'] = json_encode($value);
    }

}
