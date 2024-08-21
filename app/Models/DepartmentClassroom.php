<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentClassroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'institute',
        'department',
        'name',
        'description',
        'created_by',
        'main_faculty',
        'passkeys',
        'topics',
        'exam_types',
        'number_distribution',
        'status'
    ];


    public function institute(){
        return $this->belongsTo(Institute::class);
    }

    public function department(){
        return $this->belongsTo(InstituteDepartment::class);
    }




    // Accessor to deserialize JSON data for passkeys
    public function getPasskeysAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for passkeys
    public function setPasskeysAttribute($value){
        $this->attributes['passkeys'] = json_encode($value);
    }




    // Accessor to deserialize JSON data for toics
    public function getTopicsAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for toics
    public function setTopicsAttribute($value){
        $this->attributes['topics'] = json_encode($value);
    }




    // Accessor to deserialize JSON data for optional exam types
    public function getExamTypesAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for optional exam types
    public function setExamTypesAttribute($value){
        $this->attributes['exam_types'] = json_encode($value);
    }




    // Accessor to deserialize JSON data for optional number distribution
    public function getNumberDistributionAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for optional number distribution
    public function setNumberDistributionAttribute($value){
        $this->attributes['number_distribution'] = json_encode($value);
    }




}
