<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function attendences() {
        return $this->hasMany(Attendence::class);
    }
}
