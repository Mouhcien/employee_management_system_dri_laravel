<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function entities() {
        return $this->hasMany(Entity::class);
    }

    public function affectations() {
        return $this->hasMany(Affectation::class);
    }
}
