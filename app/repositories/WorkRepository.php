<?php

namespace App\repositories;

use App\Models\Work;

class WorkRepository extends MainRepository
{

    public function OneByEmployeeId($id, $with) {
        return Work::with($with)
            ->where('employee_id', '=', $id)
            ->where('terminated_date', '=', null)
            ->first();
    }
}
