<?php

namespace App\repositories;

use App\Models\Employee;

class EmployeeRepository extends MainRepository
{

    public function allByFilter($filter, $pages = 0)
    {
        $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'];
        $query =  Employee::with($with)
            ->where($filter['col'], '=', $filter['val'])
            ->orderBy('birth_date', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
