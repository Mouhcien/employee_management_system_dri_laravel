<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    public function cities() {
        return $this->belongsTo(City::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
