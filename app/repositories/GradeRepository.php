<?php

namespace App\repositories;

use App\Models\Grade;

class GradeRepository extends MainRepository
{

    public function AllByFilter($value, $with, $pages) {
        $query = Grade::with($with)
            ->where('title', 'LIKE', "%$value%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
