<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{

    public function relation() {
        return $this->belongsTo(Relation::class);
    }

    public function period() {
        return $this->belongsTo(Period::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
