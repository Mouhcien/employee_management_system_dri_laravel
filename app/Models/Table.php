<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function relations() {
        return $this->hasMany(Relation::class);
    }
}
