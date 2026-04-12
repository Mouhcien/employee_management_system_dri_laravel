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

    public function AllByFilter($filter, $with, $pages) {
        $query = Demand::with($with);

        if (isset($filter['fltr'])) {
            $val = $filter['fltr'];
            $query->join('employees', 'employees.id', '=', 'demands.employee_id')
                ->when($val, function ($query) use ($val) {
                    $query->where(function ($q) use ($val) {
                        $q->where('lastname', 'like', "%{$val}%")
                            ->orWhere('firstname', 'like', "%{$val}%")
                            ->orWhere('email', 'like', "%{$val}%")
                            ->orWhere('cin', 'like', "%{$val}%")
                            ->orWhere('ppr', 'like', "%{$val}%")
                            ->orWhere('birth_date', 'like', "%{$val}%")
                            ->orWhere('birth_city', 'like', "%{$val}%")
                            ->orWhere('hiring_date', 'like', "%{$val}%")
                            ->orWhere('tel', 'like', "%{$val}%");
                    });
                });
        }

        if (isset($filter['type'])) {
            $query->where('type', '=', $filter['type']);
        }

        $query->orderBy('id', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

}
