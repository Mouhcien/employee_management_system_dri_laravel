<?php

namespace App\repositories;

use App\Models\Option;

class OptionRepository extends MainRepository
{

    public function AllByFilter($value, $with, $pages) {
        $query = Option::with($with)
            ->where('title', 'LIKE', "%$value%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
