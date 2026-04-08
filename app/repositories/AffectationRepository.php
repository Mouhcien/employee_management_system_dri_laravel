<?php

namespace App\repositories;

use App\Models\Affectation;

class AffectationRepository extends MainRepository
{

    public function OneByEmployeeId($id, $with) {
        return Affectation::with($with)
            ->where('employee_id', '=', $id)
            ->where('state', '=', 1)
            ->first();
    }
}
