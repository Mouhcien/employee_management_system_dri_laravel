<?php

namespace App\repositories;

use App\Models\Entity;

class EntityRepository extends MainRepository
{

    public function AllByService($service_id, $pages) {
        $query = Entity::with(['type', 'sectors', 'sections', 'affectations', 'service'])
            ->where('service_id', '=', $service_id)
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
