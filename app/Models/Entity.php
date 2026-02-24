<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function entity_type() {
        return $this->belongsTo(EntityType::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function sectors() {
        return $this->hasMany(Sector::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }

}
