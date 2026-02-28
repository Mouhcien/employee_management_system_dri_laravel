<?php

namespace App\repositories;

use App\Models\Entity;

class EntityRepository extends MainRepository
{

    public function getAllEntityByService($service_id) {
        return Entity::with('type', 'sectors', 'sections', 'affectations', 'service')
            ->where('service_id', '=', $service_id)
            ->get();

    }
}
