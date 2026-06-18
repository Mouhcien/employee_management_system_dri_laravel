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

    public function AllByFilter($filter, $pages) {
        $query = Sector::with('entity', 'affectations')
            ->where('title', '=', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function ByTitle($title) {
        return Sector::with('entity', 'affectations')
            ->whereRaw('LOWER(title) = ?', [strtolower($title)])
            ->first();
    }

    public function AllByService($service_id, $pages) {
        $query = Sector::with('entity', 'affectations')
            ->join('entities', 'entities.id', '=', 'sectors.entity_id')
            ->where('entities.service_id', '=', $service_id)
            ->select('sectors.*')
            ->orderBy('sectors.title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByAllFilters($data, $pages) {
        $query = Sector::with('entity', 'affectations')
            ->join('entities', 'entities.id', '=', 'sectors.entity_id')
            ->select('sectors.*')
            ->orderBy('sectors.title', 'ASC');

        if (isset($data['entity_id']))
                $query->where('sectors.entity_id', '=', $data['entity_id']);

        if (isset($data['service_id']))
            $query->where('entities.service_id', '=', $data['service_id']);

        if (isset($data['filter']))
            $query->where('sectors.title', 'LIKE', "%".$data['filter']."%");

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }


}
