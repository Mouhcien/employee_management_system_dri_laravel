<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Echellon extends Model
{
    public function remunerations() {
        return $this->hasMany(Remuneration::class);
    }
}
