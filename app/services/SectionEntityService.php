<?php

namespace App\services;

use App\Models\Section;
use App\repositories\SectionEntityRepository;

class SectionEntityService
{
    private SectionEntityRepository $sectionEntityRepository;

    /**
     * @param SectionEntityRepository $sectionEntityRepository
     */
    public function __construct(SectionEntityRepository $sectionEntityRepository)
    {
        $this->sectionEntityRepository = $sectionEntityRepository;
    }

    public function getAll($pages=0){
        return $this->sectionEntityRepository->All(Section::class, ['entity', 'affectations'], $pages);
    }

    public function getOneById($id){
        return $this->sectionEntityRepository->One(Section::class, ['entity', 'affectations'], $id);
    }

    public function create($data){
        $obj = new Section();

        $obj->title = $data['title'];
        $obj->entity_id = $data['entity_id'];

        return $this->sectionEntityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];
        if (isset($data['entity_id']))
            $obj->entity_id = $data['entity_id'];

        return $this->sectionEntityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->sectionEntityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->sectionEntityRepository->LatestInserted(Section::class);
    }
}
