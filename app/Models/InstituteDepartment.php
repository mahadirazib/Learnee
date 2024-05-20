<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteDepartment extends Model
{
    use HasFactory;


    protected $fillable = [
        'institute',
        'name',
        'description',
        'department_head',
        'created_by',
        'passkeys',
        'admins',
        // subjects= ['name'= name, 'reward'= rewards(parcentage/marks/credit)]
        'subjects'
    ];


    public function institute(){
        return $this->belongsTo(Institute::class);
    }







    // Accessor to deserialize JSON data for passkeys
    public function getPasskeysAttribute($value){
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data for passkeys
    public function setPasskeysAttribute($value){
        $this->attributes['passkeys'] = json_encode($value);
    }



    // Accessor to deserialize Admins data
    public function getAdminsAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize Admins JSON data
    public function setAdminsAttribute($value)
    {
        $this->attributes['admins'] = json_encode($value);
    }



    // Accessor to deserialize Subjects data
    public function getSubjectsAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize Subjects JSON data
    public function setSubjectsAttribute($value)
    {
        $this->attributes['subjects'] = json_encode($value);
    }




}
