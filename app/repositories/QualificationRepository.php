<?php

namespace App\repositories;


use App\Models\Qualification;

class QualificationRepository extends MainRepository
{
    public function OneByEmployeeId($id, $with) {
        return Qualification::with($with)
            ->where('employee_id', $id)
            ->latest('id')
            ->first();
    }
}
