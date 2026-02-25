<?php

namespace App\services;

use App\Models\City;
use App\repositories\CityRepository;

class CityService
{
    private CityRepository $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAll($pages=0){
        return $this->cityRepository->All(City::class, ['locals'], $pages);
    }

    public function getOneById($id){
        return $this->cityRepository->One(City::class, ['locals'], $id);
    }

    public function create($data){
        $obj = new City();

        $obj->title = $data['title'];

        return $this->cityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->cityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->cityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->cityRepository->LatestInserted(City::class);
    }
}
