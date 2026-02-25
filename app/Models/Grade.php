<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function classements() {
        return $this->hasMany(Classement::class);
    }
}
