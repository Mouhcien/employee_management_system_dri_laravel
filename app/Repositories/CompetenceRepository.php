<?php

namespace App\repositories;

use App\Models\Competence;

class CompetenceRepository extends MainRepository
{

    public function OneByEmployeeId($id, $with) {
        return Competence::with($with)
            ->where('employee_id', '=', $id)
            ->where('finished_date', '=', null)
            ->first();
    }
}
