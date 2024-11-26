<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_code',
        'mobile_number',
        'address',
        'gender',
        'hobby',
        'photo',
    ];


    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }


    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }


    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function setHobbyAttribute($value)
    {
        $this->attributes['hobby'] = json_encode($value);
    }

    public function getHobbyAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset('Storage/employee/' . $value) : null;
    }
}
