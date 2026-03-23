<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function competences() {
        return $this->hasMany(Competence::class);
    }
}
