<?php

namespace App\services;

use App\Models\Work;
use App\repositories\WorkRepository;

class WorkService
{
    private WorkRepository $workRepository;
    private $with = ['occupation', 'employee'];

    /**
     * @param WorkRepository $workRepository
     */
    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function getAll($pages=0){
        return $this->workRepository->All(Work::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->workRepository->One(Work::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Work();

        $obj->occupation_id = $data['occupation_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->starting_date = $data['starting_date'];

        return $this->workRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['occupation_id']))
            $obj->occupation_id = $data['occupation_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        if (isset($data['terminated_date']))
            $obj->terminated_date = $data['terminated_date'];

        return $this->workRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->workRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->workRepository->LatestInserted(Work::class);
    }
}
