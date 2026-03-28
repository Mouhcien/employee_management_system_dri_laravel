<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    public function relations() {
        return $this->hasMany(Relation::class);
    }
}
