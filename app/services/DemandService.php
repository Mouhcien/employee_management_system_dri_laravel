<?php

namespace App\services;

use App\Models\Demand;
use App\repositories\DemandRepository;

class DemandService
{
    private DemandRepository $demandRepository;
    private $with = ['mutation'];

    /**
     * @param DemandRepository $demandRepository
     */
    public function __construct(DemandRepository $demandRepository)
    {
        $this->demandRepository = $demandRepository;
    }

    public function getAll($pages=0){
        return $this->demandRepository->All(Demand::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->demandRepository->One(Demand::class, $this->with, $id);
    }

    public function getAllByEmployee($employee_id, $pages){
        return $this->demandRepository->AllByEmployee($employee_id, $this->with, $pages);
    }

    public function getAllByState($state, $pages){
        return $this->demandRepository->AllByState($state, $this->with, $pages);
    }

    public function getAllByFilter($filter, $pages){
        return $this->demandRepository->AllByFilter($filter, $this->with, $pages);
    }

    public function create($data){
        $obj = new Demand();

        $obj->title = $data['title'];
        $obj->object = $data['object'];
        $obj->demand_date = $data['demand_date'];
        $obj->type = $data['type'];
        $obj->employee_id = $data['employee_id'];
        if (isset($data['file']))
            $obj->file = $data['file'];

        return $this->demandRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];
        if (isset($data['object']))
            $obj->object = $data['object'];
        if (isset($data['demand_date']))
            $obj->demand_date = $data['demand_date'];
        if (isset($data['type']))
            $obj->type = $data['type'];
        if (isset($data['file']))
            $obj->file = $data['file'];
        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];
        if (isset($data['state']))
            $obj->state = $data['state'];

        return $this->demandRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->demandRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->demandRepository->LatestInserted(Demand::class);
    }

}
