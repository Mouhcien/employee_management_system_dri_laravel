<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    public function qualifications() {
        return $this->hasMany(Qualification::class);
    }
}
