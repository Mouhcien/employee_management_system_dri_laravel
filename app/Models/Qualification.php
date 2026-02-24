<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function diploma() {
        return $this->belongsTo(Diploma::class);
    }
}
