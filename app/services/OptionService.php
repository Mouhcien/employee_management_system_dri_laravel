<?php

namespace App\services;

use App\Models\Option;
use App\repositories\OptionRepository;

class OptionService
{
    private OptionRepository $optionRepository;

    /**
     * @param OptionRepository $optionRepository
     */
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function getAll($pages=0){
        return $this->optionRepository->All(Option::class, ['qualifications'], $pages);
    }

    public function getAllByFilter($value, $pages=0){
        return $this->optionRepository->AllByFilter($value, ['qualifications'], $pages);
    }

    public function getOneById($id){
        return $this->optionRepository->One(Option::class, ['qualifications'], $id);
    }

    public function create($data){
        $obj = new Option();

        $obj->title = $data['title'];

        return $this->optionRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->optionRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->optionRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->optionRepository->LatestInserted(Option::class);
    }
}
