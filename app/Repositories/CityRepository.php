<?php

namespace App\repositories;

use App\Models\City;

class CityRepository extends MainRepository
{

    public function AllByLocal($local_id, $pages = 0)
    {
        $query = City::whereHas('locals', function ($q) use ($local_id) {
            $q->where('id', $local_id);
        })
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByFilter($filter, $pages=0){
        $query = City::with('locals')
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

}
