<?php

namespace App\services;

use App\Models\Occupation;
use App\repositories\OccupationRepository;

class OccupationService
{
    private OccupationRepository $occupationRepository;

    /**
     * @param OccupationRepository $occupationRepository
     */
    public function __construct(OccupationRepository $occupationRepository)
    {
        $this->occupationRepository = $occupationRepository;
    }

    public function getAll($pages=0){
        return $this->occupationRepository->All(Occupation::class, ['works'], $pages);
    }

    public function getOneById($id){
        return $this->occupationRepository->One(Occupation::class, ['works'], $id);
    }

    public function create($data){
        $obj = new Occupation();

        $obj->title = $data['title'];

        return $this->occupationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->occupationRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->occupationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->occupationRepository->LatestInserted(Occupation::class);
    }
}
