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

    public function AllByFilter($filter, $pages) {
        $query = Entity::with(['type', 'sectors', 'sections', 'affectations', 'service'])
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByType($type_id, $pages) {
        $query = Entity::with(['type', 'sectors', 'sections', 'affectations', 'service'])
            ->where('type_id', '=', $type_id)
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
