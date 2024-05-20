<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'images',
        'description',
        'created_by',
        'institute_head',
        'admins',
        'passkeys',
        'emails',
        'mobile_numbers',
        'address_one',
        'address_two'

    ];

    protected $casts = [
        'admins' => 'json',
    ];
    


    public function faculty()
    {
        return $this->belongsToMany(User::class, 'institute_faculties', 'institute', 'faculty');
    }



    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function instituteHead()
    {
        return $this->belongsTo(User::class, 'institute_head');
    }



    // Accessor to deserialize JSON data
    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize JSON data
    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
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



    // Accessor to deserialize Passkeys data
    public function getPasskeysAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize Admins JSON data
    public function setPasskeysAttribute($value)
    {
        $this->attributes['passkeys'] = json_encode($value);
    }


    // Accessor to deserialize Passkeys data
    public function getEmailsAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize Admins JSON data
    public function setEmailsAttribute($value)
    {
        $this->attributes['emails'] = json_encode($value);
    }


    // Accessor to deserialize Passkeys data
    public function getMobileNumbersAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator to serialize Admins JSON data
    public function setMobileNumbersAttribute($value)
    {
        $this->attributes['mobile_numbers'] = json_encode($value);
    }
}
