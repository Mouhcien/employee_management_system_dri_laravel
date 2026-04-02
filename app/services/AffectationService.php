<?php

namespace App\services;

use App\Models\Affectation;
use App\repositories\AffectationRepository;

class AffectationService
{
    private AffectationRepository $affectationRepository;
    private $with = ['employee', 'service', 'entity', 'sector', 'section'];

    /**
     * @param AffectationRepository $affectationRepository
     */
    public function __construct(AffectationRepository $affectationRepository)
    {
        $this->affectationRepository = $affectationRepository;
    }

    public function getAll($pages=0){
        return $this->affectationRepository->All(Affectation::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->affectationRepository->One(Affectation::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Affectation();

        if ($data['service_id'] != 'null')
            $obj->service_id = $data['service_id'];
        if ($data['entity_id'] != 'null')
            $obj->entity_id = $data['entity_id'];
        if ($data['sector_id'] != 'null')
            $obj->sector_id = $data['sector_id'];
        if ($data['section_id'] != 'null')
            $obj->section_id = $data['section_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->affectation_date = $data['affectation_date'];

        return $this->affectationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        $obj->service_id = $data['service_id'];

        if ($data['entity_id'] == 'null')
            $obj->entity_id = null;
        else
            $obj->entity_id = $data['entity_id'];

        if ($data['sector_id'] == 'null')
            $obj->sector_id = null;
        else
            $obj->sector_id = $data['sector_id'];

        if ($data['section_id'] == 'null')
            $obj->section_id = null;
        else
            $obj->section_id = $data['section_id'];

        $obj->employee_id = $data['employee_id'];

        $obj->affectation_date = $data['affectation_date'];

        return $this->affectationRepository->Update($obj);
    }

    public function changeState($id, $state){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        $obj->state = $state;
        $obj->finished_date = now();

        return $this->affectationRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->affectationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->affectationRepository->LatestInserted(Affectation::class);
    }
}
