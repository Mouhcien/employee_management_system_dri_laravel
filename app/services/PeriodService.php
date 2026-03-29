<?php

namespace App\services;

use App\Models\Period;
use App\repositories\PeriodRepository;

class PeriodService
{

    private PeriodRepository $periodRepository;
    private $with = ['values'];

    /**
     * @param PeriodRepository $periodRepository
     */
    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    public function getAll($pages=0){
        return $this->periodRepository->All(Period::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->periodRepository->One(Period::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Period();

        $obj->title = $data['title'];
        $obj->starting_date = $data['starting_date'];
        $obj->end_date = $data['end_date'];

        return $this->periodRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        if (isset($data['end_date']))
            $obj->end_date = $data['end_date'];

        return $this->periodRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->periodRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->periodRepository->LatestInserted(Period::class);
    }
}
