<?php

namespace App\repositories;

use App\Models\Service;

class ServiceEntityRepository extends MainRepository
{

    public function AllByFilter($filter, $with, $pages) {
        $query = Service::with($with)
            ->where('title', 'LIKE', "%$filter%");

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

}
