<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function competences() {
        return $this->hasMany(Competence::class);
    }
}
