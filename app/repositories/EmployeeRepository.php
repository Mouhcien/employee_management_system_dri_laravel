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
            ->orderBy('lastname', 'ASC');

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

    public function getAllByAdvanceFilter($filter, $pages){
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id');

        if (isset($filter['services']))
            $query->whereIn('affectations.service_id', $filter['services']);

        if (isset($filter['entities']))
            $query->whereIn('affectations.entity_id', $filter['entities']);

        if (isset($filter['sectors']))
            $query->whereIn('affectations.sector_id', $filter['sectors']);

        if (isset($filter['sections']))
            $query->whereIn('affectations.section_id', $filter['sections']);

        if (isset($filter['locals']))
            $query->whereIn('local_id', $filter['locals']);

        if (isset($filter['cities'])) {
            $query->join('locals', 'locals.id', '=', 'employees.local_id');
            $query->whereIn('locals.city_id', $filter['cities']);
        }

        if (isset($filter['gender']))
            $query->where('gender', '=', $filter['gender']);

        $query->where('affectations.state', '=', '1');
        $query->orderBy('employees.lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }


    public function getOneByPPR($ppr) {
        return Employee::with($this->with)
            ->where('ppr', '=', $ppr)
            ->first();
    }

    public function allByCategory($category_id, $with, $pages) {
        $query =  Employee::with($with)
            ->where('category_id', '=', $category_id)
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allTotalByCategory() {
        return Employee::query()
            ->join('categories', 'categories.id', '=', 'employees.category_id')
            ->selectRaw('employees.category_id, categories.title, COUNT(employees.id) AS total')
            ->groupBy('employees.category_id', 'categories.title')
            ->get();
    }


}
