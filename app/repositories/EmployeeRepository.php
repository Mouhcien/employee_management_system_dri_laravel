<?php

namespace App\repositories;

use App\Models\Employee;

class EmployeeRepository extends MainRepository
{
    private array $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'];

    public function allByFilter($filter, $pages = 0)
    {

        $query =  Employee::with($this->with)
            ->where($filter['col'], '=', $filter['val'])
            ->orderBy('birth_date', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterValue($val, $pages = 0)
    {
        $query = Employee::with($this->with)
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

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterAdvanced($filter, $pages = 0)
    {
        $query =  Employee::with($this->with);

        if (isset($filter['local_id']))
            $query->where('local_id', '=', $filter['local_id']);

        if (isset($filter['city_id'])) {
            $query->join('locals', 'locals.id', '=', 'employees.local_id');
            $query->where('locals.city_id', '=', $filter['city_id']);
        }

        if (isset($filter['gender']))
            $query->where('gender', '=', $filter['gender']);

        $query->orderBy('birth_date', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }


    public function getOneByPPR($ppr) {
        return Employee::with($this->with)
            ->where('ppr', '=', $ppr)
            ->first();
    }


}
