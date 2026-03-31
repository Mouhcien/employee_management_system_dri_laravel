<?php

namespace App\repositories;

use App\Models\Value;

class ValueRepository extends MainRepository
{

    public function AllByTable($table_id, $with, $pages) {

        $query = Value::with($with)
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->where('relations.table_id', '=', $table_id)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }

    public function AllByPeriod($period_id, $with, $pages) {

        $query = Value::with($with)
            ->where('values.period_id', '=', $period_id)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }

    public function AllByEmployee($employee_id, $with, $pages) {

        $query = Value::with($with)
            ->where('values.employee_id', '=', $employee_id)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }

    public function AllByFilter($filter, $with, $pages) {

        $query = Value::with($with)
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

            if (isset($filter['table_id']))
                $query->where('relations.table_id', '=', $filter['table_id']);
            if (isset($filter['employee_id']))
                $query->where('values.employee_id', '=', $filter['employee_id']);
            if (isset($filter['period_id']))
                $query->where('values.period_id', '=', $filter['period_id']);

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }

    public function AllByIds($values_id, $with) {

        $query = Value::with($with)
            ->whereIn('values.id', $values_id)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $query->get();

    }

    public function getAllByService($service_id, $with) {

        $query = Value::with($with)
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.service_id', '=', $service_id)
            ->where('affectations.state', '=', true)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $query->get();

    }

    public function getAllByEntity($entity_id, $with) {

        $query = Value::with($with)
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.entity_id', '=', $entity_id)
            ->where('affectations.state', '=', true)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $query->get();

    }

    public function getAllBySector($sector_id, $with) {

        $query = Value::with($with)
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.sector_id', '=', $sector_id)
            ->where('affectations.state', '=', true)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $query->get();

    }

    public function getAllBySection($section_id, $with) {

        $query = Value::with($with)
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.section', '=', $section_id)
            ->where('affectations.state', '=', true)
            ->select('values.*')
            ->orderBy('values.period_id', 'DESC');

        return $query->get();

    }

}
