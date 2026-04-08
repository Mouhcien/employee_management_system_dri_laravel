<?php

namespace App\repositories;

use App\Models\Occupation;

class OccupationRepository extends MainRepository
{

    public function AllByFilter($filter, $with, $pages) {
        $query = Occupation::with($with)
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);

    }

    public function ByTitle($title, $with) {
        return Occupation::with($with)
            ->whereRaw('LOWER(title) = ?', [strtolower($title)])
            ->first();
    }
}
