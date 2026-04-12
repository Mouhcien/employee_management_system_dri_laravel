<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    public function fromAffectation()
    {
        return $this->belongsTo(Affectation::class, 'from_affectation_id');
    }

    public function toAffectation()
    {
        return $this->belongsTo(Affectation::class, 'to_affectation_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function demand() {
        return $this->belongsTo(Demand::class);
    }
}
