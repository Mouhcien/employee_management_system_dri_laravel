<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }
}
