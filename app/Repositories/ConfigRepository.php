<?php

namespace App\repositories;

use App\Models\Config;

class ConfigRepository extends MainRepository
{

    public function AllByUser($user_id, $with, $pages) {
        $query = Config::with($with)
            ->where('user_id', '=', $user_id);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
