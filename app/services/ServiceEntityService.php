<?php

namespace App\services;

use App\Models\Service;
use App\repositories\ServiceEntityRepository;

class ServiceEntityService
{
    private ServiceEntityRepository $serviceEntityRepository;

    /**
     * @param ServiceEntityRepository $serviceEntityRepository
     */
    public function __construct(ServiceEntityRepository $serviceEntityRepository)
    {
        $this->serviceEntityRepository = $serviceEntityRepository;
    }

    public function getAll($pages=0){
        return $this->serviceEntityRepository->All(Service::class, ['entities', 'affectations'], $pages);
    }

    public function getOneById($id){
        return $this->serviceEntityRepository->One(Service::class, ['entities', 'affectations'], $id);
    }

    public function create($data){
        $obj = new Service();

        $obj->title = $data['title'];

        return $this->serviceEntityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->serviceEntityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->serviceEntityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->serviceEntityRepository->LatestInserted(Service::class);
    }
}
