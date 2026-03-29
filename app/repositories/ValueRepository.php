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

}
