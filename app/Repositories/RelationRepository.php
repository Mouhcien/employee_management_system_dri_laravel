<?php

namespace App\repositories;

use App\Models\Relation;

class RelationRepository extends MainRepository
{

    public function getRelationWhichColumnNotInNewList($table_id, $submittedColumnIds, $with) {
        return Relation::with($with)
            ->where('table_id', $table_id)
            ->whereNotIn('column_id', $submittedColumnIds)
            ->get();
    }

    public function AllByTable($table_id, $with) {
        return Relation::with($with)
            ->where('table_id', $table_id)
            ->get();
    }
}
