<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
