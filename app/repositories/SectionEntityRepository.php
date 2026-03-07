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
}
