<?php

namespace App\services;

use App\Models\Entity;
use App\repositories\EntityRepository;

class EntityService
{
    private EntityRepository $entityRepository;

    /**
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function getAll($pages=0){
        return $this->entityRepository->All(Entity::class, ['type', 'sectors', 'sections', 'affectations', 'service'], $pages);
    }

    public function getOneById($id){
        return $this->entityRepository->One(Entity::class, ['type', 'sectors', 'sections', 'affectations', 'service'], $id);
    }

    public function create($data){
        $obj = new Entity();

        $obj->title = $data['title'];
        $obj->service_id = $data['service_id'];
        $obj->type_id = $data['type_id'];

        return $this->entityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];
        if (isset($data['service_id']))
            $obj->service_id = $data['service_id'];
        if (isset($data['type_id']))
            $obj->type_id = $data['type_id'];

        return $this->entityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->entityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->entityRepository->LatestInserted(Entity::class);
    }

    public function getAllEntityByService($service_id){
        return $this->entityRepository->getAllEntityByService($service_id);
    }
}
