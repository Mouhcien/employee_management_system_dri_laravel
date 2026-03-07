<?php

namespace App\repositories;

use App\Models\Sector;

class SectorEntityRepository extends MainRepository
{

    public function AllByByEntity($entity_id, $pages) {
        $query = Sector::with('entity', 'affectations')
            ->where('entity_id', '=', $entity_id)
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
