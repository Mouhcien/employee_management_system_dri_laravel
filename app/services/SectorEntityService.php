<?php

namespace App\services;

use App\Models\Sector;
use App\Models\SectorEntity;
use App\repositories\SectorEntityRepository;

class SectorEntityService
{
    private SectorEntityRepository $sectorEntityRepository;

    /**
     * @param SectorEntityRepository $sectorEntityRepository
     */
    public function __construct(SectorEntityRepository $sectorEntityRepository)
    {
        $this->sectorEntityRepository = $sectorEntityRepository;
    }

    public function getAll($pages=0){
        return $this->sectorEntityRepository->All(Sector::class, ['entity', 'affectations'], $pages);
    }

    public function getOneById($id){
        return $this->sectorEntityRepository->One(Sector::class, ['entity', 'affectations'], $id);
    }

    public function create($data){
        $obj = new Sector();

        $obj->title = $data['title'];
        $obj->entity_id = $data['entity_id'];

        return $this->sectorEntityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];
        if (isset($data['entity_id']))
            $obj->entity_id = $data['entity_id'];

        return $this->sectorEntityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->sectorEntityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->sectorEntityRepository->LatestInserted(Sector::class);
    }
}
