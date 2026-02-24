<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function echellon() {
        return $this->belongsTo(Echellon::class);
    }
}
