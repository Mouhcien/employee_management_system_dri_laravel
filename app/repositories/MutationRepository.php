<?php

namespace App\repositories;

use App\Models\Mutation;

class MutationRepository extends MainRepository
{

    public function AllByFilter($filter, $with, $pages) {
        $query = Mutation::with($with);

        if (isset($filter['fltr'])) {
            $val = $filter['fltr'];
            $query->join('employees', 'employees.id', '=', 'mutations.employee_id')
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

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }
}
