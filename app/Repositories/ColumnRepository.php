<?php

namespace App\repositories;

use App\Models\Column;

class ColumnRepository extends MainRepository
{

    public function AllColumnsByTable($table_id, $with) {
        return Column::with($with)
            ->join('relations', 'relations.column_id', '=', 'columns.id')
            ->where('relations.table_id', '=', $table_id)
            ->select('columns.*')
            ->orderBy('columns.id', 'ASC')
            ->get();
    }
}
