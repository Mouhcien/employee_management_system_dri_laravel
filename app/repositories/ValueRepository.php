<?php

namespace App\repositories;

use App\Models\Relation;
use App\Models\Value;
use Illuminate\Support\Facades\DB;

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

        return Value::selectRaw('
            "values".period_id,
            relations.column_id,
            relations.table_id,
            tables.title as table_title,
            columns.title as column_title,
            SUM(CAST("values"."value" AS DECIMAL(10,2))) as total_sum
        ')
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->join('columns', 'columns.id', '=', 'relations.column_id')
            ->join('tables', 'tables.id', '=', 'relations.table_id') // Added join for table title
            ->where('affectations.service_id', '=', $service_id)
            ->where('affectations.state', '=', true)
            ->with('period') // Keep this for the date/year display
            ->groupBy(
                'values.period_id',
                'relations.column_id',
                'relations.table_id',
                'tables.title',
                'columns.title',
                'columns.id'
            )
            ->orderBy('values.period_id', 'DESC')
            ->get();

    }

    public function getAllByEntity($entity_id, $with) {

        return Value::selectRaw('
            "values".period_id,
            relations.column_id,
            relations.table_id,
            tables.title as table_title,
            columns.title as column_title,
            SUM(CAST("values"."value" AS DECIMAL(10,2))) as total_sum
        ')
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->join('columns', 'columns.id', '=', 'relations.column_id')
            ->join('tables', 'tables.id', '=', 'relations.table_id') // Added join for table title
            ->where('affectations.entity_id', '=', $entity_id)
            ->where('affectations.state', '=', true)
            ->with('period') // Keep this for the date/year display
            ->groupBy(
                'values.period_id',
                'relations.column_id',
                'relations.table_id',
                'tables.title',
                'columns.title',
                'columns.id'
            )
            ->orderBy('values.period_id', 'DESC')
            ->get();

    }

    public function getAllBySector($sector_id, $with) {

        return Value::selectRaw('
            "values".period_id,
            relations.column_id,
            relations.table_id,
            tables.title as table_title,
            columns.title as column_title,
            SUM(CAST("values"."value" AS DECIMAL(10,2))) as total_sum
        ')
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->join('columns', 'columns.id', '=', 'relations.column_id')
            ->join('tables', 'tables.id', '=', 'relations.table_id') // Added join for table title
            ->where('affectations.sector_id', '=', $sector_id)
            ->where('affectations.state', '=', true)
            ->with('period') // Keep this for the date/year display
            ->groupBy(
                'values.period_id',
                'relations.column_id',
                'relations.table_id',
                'tables.title',
                'columns.title',
                'columns.id'
            )
            ->orderBy('values.period_id', 'DESC')
            ->get();

    }

    public function getAllBySection($section_id, $with) {

        return Value::selectRaw('
            "values".period_id,
            relations.column_id,
            relations.table_id,
            tables.title as table_title,
            columns.title as column_title,
            SUM(CAST("values"."value" AS DECIMAL(10,2))) as total_sum
        ')
            ->join('employees', 'employees.id', '=', 'values.employee_id')
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->join('relations', 'relations.id', '=', 'values.relation_id')
            ->join('columns', 'columns.id', '=', 'relations.column_id')
            ->join('tables', 'tables.id', '=', 'relations.table_id') // Added join for table title
            ->where('affectations.section_id', '=', $section_id)
            ->where('affectations.state', '=', true)
            ->with('period') // Keep this for the date/year display
            ->groupBy(
                'values.period_id',
                'relations.column_id',
                'relations.table_id',
                'tables.title',
                'columns.title',
                'columns.id'
            )
            ->orderBy('values.period_id', 'DESC')
            ->get();

    }

}
