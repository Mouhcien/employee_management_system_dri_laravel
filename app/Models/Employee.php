<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'ppr',
        'cin',
        'firstname',
        'lastname',
        'firstname_arab',
        'lastname_arab',
        'birth_date',
        'birth_city',
        'gender',
        'sit',
        'hiring_date',
        'local_id',
        'address',
        'city',
        'tel',
        'email',
        'photo',
        'status'
    ];

    public function works() {
        return $this->hasMany(Work::class);
    }

    public function qualifications() {
        return $this->hasMany(Qualification::class);
    }

    public function competences() {
        return $this->hasMany(Competence::class);
    }

    public function remunerations() {
        return $this->hasMany(Remuneration::class);
    }

    public function chefs() {
        return $this->hasMany(Qualification::class);
    }

    public function affectations() {
        return $this->hasMany(Affectation::class);
    }

}
