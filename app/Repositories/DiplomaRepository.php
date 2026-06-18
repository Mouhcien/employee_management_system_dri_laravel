<?php

namespace App\repositories;

use App\Models\Diploma;

class DiplomaRepository extends MainRepository
{

    public function AllByFilter($filter, $with, $pages) {
        $query = Diploma::with($with)
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function ByTitle($title, $with) {
        return  Diploma::with($with)
            ->whereRaw('LOWER(title) = ?', [strtolower($title)])
            ->first();
    }

}
