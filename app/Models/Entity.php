<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function affectations() {
        return $this->hasMany(Affectation::class);
    }

    public function sectors() {
        return $this->hasMany(Sector::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }

}
