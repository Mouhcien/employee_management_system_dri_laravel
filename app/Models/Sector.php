<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
