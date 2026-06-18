<?php

namespace App\repositories;

use App\Models\Chef;

class ChefRepository extends MainRepository
{

    public function AllByService($service_id, $with, $pages) {
        $query = Chef::with($with)
            ->where('chefs.service_id', $service_id);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByEntity($entity_id, $with, $pages) {
        $query = Chef::with($with)
            ->where('chefs.entity_id', $entity_id);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllBySector($sector_id, $with, $pages) {
        $query = Chef::with($with)
            ->where('chefs.sector_id', $sector_id);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllBySection($section_id, $with, $pages) {
        $query = Chef::with($with)
            ->where('chefs.section_id', $section_id);

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByFilter($filter, $with, $pages) {
        $query = Chef::with($with)
            ->join('employees', 'employees.id', '=', 'chefs.employee_id')
            ->where(function ($q) use ($filter) {
                $q->where('employees.firstname', 'LIKE', "%$filter%")
                    ->orWhere('employees.lastname', 'LIKE', "%$filter%");

            });

        /**
         *
         *
        ->join('services', 'services.id', '=', 'chefs.service_id')
        ->join('entities', 'entities.id', '=', 'chefs.entity_id')
        ->join('sections', 'sections.id', '=', 'chefs.section_id')
        ->join('sectors', 'sectors.id', '=', 'chefs.sector_id')
         *

        ->orWhere('services.title', 'LIKE', "%$filter%");
        ->orWhere('entities.title', 'LIKE', "%$filter%")
        ->orWhere('sections.title', 'LIKE', "%$filter%")
        ->orWhere('sectors.title', 'LIKE', "%$filter%");
        */
        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }


}
