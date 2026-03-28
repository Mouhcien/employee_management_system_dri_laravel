<?php

namespace App\repositories;

use App\Models\Relation;

class RelationRepository extends MainRepository
{

    public function getRelationWhichColumnNotInNewList($table_id, $submittedColumnIds) {
        return Relation::with(['table', 'column'])
            ->where('table_id', $table_id)
            ->whereNotIn('column_id', $submittedColumnIds)
            ->get();
    }
}
