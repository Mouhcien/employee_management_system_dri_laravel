<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

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
