<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function affectations() {
        return $this->hasMany(Affectation::class);
    }
}
