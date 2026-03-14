<?php

namespace App\services;

use App\Models\Chef;
use App\repositories\ChefRepository;

class ChefService
{
    private ChefRepository $chefRepository;
    private $with = ['employee', 'service', 'entity', 'sector', 'section'];

    /**
     * @param ChefRepository $chefRepository
     */
    public function __construct(ChefRepository $chefRepository)
    {
        $this->chefRepository = $chefRepository;
    }

    public function getAll($pages=0){
        return $this->chefRepository->All(Chef::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->chefRepository->One(Chef::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Chef();

        if ($data['service_id'] != 'null')
            $obj->service_id = $data['service_id'];
        if ($data['entity_id'] != 'null')
            $obj->entity_id = $data['entity_id'];
        if ($data['sector_id'] != 'null')
            $obj->sector_id = $data['sector_id'];
        if ($data['section_id'] != 'null')
            $obj->section_id = $data['section_id'];
        if ($data['decision_file'] != 'null')
            $obj->decision_file = $data['decision_file'];
        $obj->employee_id = $data['employee_id'];
        $obj->starting_date = $data['starting_date'];

        return $this->chefRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['service_id']))
            $obj->service_id = $data['service_id'];

        if (isset($data['entity_id']))
            $obj->entity_id = $data['entity_id'];

        if (isset($data['sector_id']))
            $obj->sector_id = $data['sector_id'];

        if (isset($data['section_id']))
            $obj->section_id = $data['section_id'];

        if (isset($data['decision_file']))
            $obj->decision_file = $data['decision_file'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        if (isset($data['finishing_date']))
            $obj->finishing_date = $data['finishing_date'];

        return $this->chefRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->chefRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->chefRepository->LatestInserted(Chef::class);
    }
}
