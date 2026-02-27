<?php

namespace App\services;

use App\Models\Local;
use App\repositories\LocalRepository;

class LocalService
{

    private LocalRepository $localRepository;

    /**
     * @param LocalRepository $localRepository
     */
    public function __construct(LocalRepository $localRepository)
    {
        $this->localRepository = $localRepository;
    }

    public function getAll($pages=0){
        return $this->localRepository->All(Local::class, ['city'], $pages);
    }

    public function getOneById($id){
        return $this->localRepository->One(Local::class, ['city'], $id);
    }

    public function create($data){
        $obj = new Local();

        $obj->title = $data['title'];
        $obj->city_id = $data['city_id'];

        return $this->localRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        if (isset($data['city_id']))
            $obj->city_id = $data['city_id'];

        return $this->localRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->localRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->localRepository->LatestInserted(Local::class);
    }
}
