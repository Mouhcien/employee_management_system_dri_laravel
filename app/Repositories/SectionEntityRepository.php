<?php

namespace App\repositories;

use App\Models\Section;

class SectionEntityRepository extends MainRepository
{
    public function getAllByEntity($entity_id, $pages) {
        $query = Section::with('entity', 'affectations')
            ->where('entity_id', '=', $entity_id)
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByFilter($filter, $pages) {
        $query = Section::with('entity', 'affectations')
            ->where('title', '=', "%$filter%")
            ->orderBy('title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByTitle($title) {
        return Section::with('entity', 'affectations')
            ->whereRaw('LOWER(title) = ?', [strtolower($title)])
            ->first();
    }

    public function AllByService($service_id, $pages) {
        $query = Section::with('entity', 'affectations')
            ->join('entities', 'entities.id', '=', 'sections.entity_id')
            ->where('entities.service_id', '=', $service_id)
            ->select('sections.*')
            ->orderBy('sections.title', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByAllFilters($data, $pages) {
        $query = Section::with('entity', 'affectations')
            ->join('entities', 'entities.id', '=', 'sections.entity_id')
            ->select('sections.*')
            ->orderBy('sections.title', 'ASC');

        if (isset($data['entity_id']))
            $query->where('sections.entity_id', '=', $data['entity_id']);

        if (isset($data['service_id']))
            $query->where('entities.service_id', '=', $data['service_id']);

        if (isset($data['filter']))
            $query->where('sections.title', 'LIKE', "%".$data['filter']."%");

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
