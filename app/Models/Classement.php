<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classement extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }
}
