<?php

namespace App\services;

use App\Models\Entity;
use App\repositories\EntityRepository;

class EntityService
{
    private EntityRepository $entityRepository;
    private $with = ['type', 'sectors', 'sections', 'affectations', 'service', 'chefs'];

    /**
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function getAll($pages = 0)
    {
        return $this->entityRepository->All(Entity::class, $this->with, $pages);
    }

    public function getAllByService($service_id, $pages = 0)
    {
        return $this->entityRepository->AllByService($service_id, $pages);
    }

    public function getAllByFilter($filter, $pages = 0)
    {
        return $this->entityRepository->AllByFilter($filter, $pages);
    }

    public function getByTitle($title)
    {
        return $this->entityRepository->ByTitle($title);
    }

    public function getAllBytype($type_id, $pages = 0)
    {
        return $this->entityRepository->AllByType($type_id, $pages);
    }

    public function getAllByAllFilters($date, $pages = 0)
    {
        return $this->entityRepository->AllByAllFilters($date, $pages);
    }

    public function getAllEntityByService($service_id, $pages = 0)
    {
        return $this->getAllByService($service_id, $pages);
    }

    public function getOneById($id)
    {
        return $this->entityRepository->One(Entity::class, $this->with, $id);
    }

    public function create($data)
    {
        $obj = new Entity();

        $obj->title = $data['title'];
        $obj->service_id = $data['service_id'];
        $obj->type_id = $data['type_id'];

        return $this->entityRepository->Add($obj);
    }

    public function update($id, $data)
    {
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
    public function delete($id)
    {
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->entityRepository->Delete($obj);
    }

    public function getLatestInserted()
    {
        return $this->entityRepository->LatestInserted(Entity::class);
    }

}
