<?php

namespace App\services;

use App\Models\Temp;
use App\repositories\TempRepository;

class TempService
{

    private TempRepository $tempRepository;
    private $with = ['employee', 'chef'];

    /**
     * @param TempRepository $tempRepository
     */
    public function __construct(TempRepository $tempRepository)
    {
        $this->tempRepository = $tempRepository;
    }

    public function getAll($pages=0){
        return $this->tempRepository->All(Temp::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->tempRepository->One(Temp::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Temp();

        $obj->chef_id = $data['chef_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->starting_date = $data['starting_date'];
        if (isset($data['finished_date']))
            $obj->finished_date = $data['finished_date'];
        if (isset($data['file']))
            $obj->file = $data['file'];

        return $this->tempRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['chef_id']))
            $obj->chef_id = $data['chef_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        if (isset($data['file']))
            $obj->file = $data['file'];

        if (isset($data['finishing_date']))
            $obj->finishing_date = $data['finishing_date'];

        if (isset($data['state']))
            $obj->state = $data['state'];

        return $this->tempRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->tempRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->tempRepository->LatestInserted(Temp::class);
    }

}
