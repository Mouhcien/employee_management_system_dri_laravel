<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public function values() {
        return $this->hasMany(Relation::class);
    }
}
