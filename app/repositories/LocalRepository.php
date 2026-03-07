<?php

namespace App\repositories;

use App\Models\Local;

class LocalRepository extends MainRepository
{

    public function AllByCity($city_id): \Illuminate\Database\Eloquent\Collection
    {
        return Local::with('city')
            ->where('city_id', '=', $city_id)
            ->get();
    }
}
