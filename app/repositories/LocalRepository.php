<?php

namespace App\repositories;

use App\Models\Local;

class LocalRepository extends MainRepository
{

    public function AllByCity($city_id, $pages)
    {
        $query =  Local::with('city')
            ->where('city_id', '=', $city_id)
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByFilter($filter, $pages)
    {
        $query =  Local::with('city')
            ->join('cities', 'cities.id', '=', 'locals.city_id')
            ->where('locals.title', 'LIKE', "%$filter%")
            ->orWhere('cities.title', 'LIKE', "%$filter%")
            ->select('locals.*')
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
