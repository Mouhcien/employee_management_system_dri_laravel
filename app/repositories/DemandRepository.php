<?php

namespace App\repositories;

use App\Models\Demand;

class DemandRepository extends MainRepository
{

    public function AllByEmployee($employee_id, $with, $pages) {
        $query = Demand::with($with)
            ->where('employee_id', '=', $employee_id)
            ->where('state', '=', 1);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByState($state, $with, $pages) {
        $query = Demand::with($with)
            ->where('state', '=', $state)
            ->orderBy('id', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
