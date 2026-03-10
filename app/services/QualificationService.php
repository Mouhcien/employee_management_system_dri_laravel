<?php

namespace App\services;

use App\Models\Qualification;
use App\repositories\QualificationRepository;

class QualificationService
{
    private QualificationRepository $qualificationRepository;
    private $with = ['diploma', 'employee', 'option'];

    /**
     * @param QualificationRepository $qualificationRepository
     */
    public function __construct(QualificationRepository $qualificationRepository)
    {
        $this->qualificationRepository = $qualificationRepository;
    }

    public function getAll($pages=0){
        return $this->qualificationRepository->All(Qualification::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->qualificationRepository->One(Qualification::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Qualification();

        $obj->diploma_id = $data['diploma_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->option_id = $data['option_id'];
        if (isset($data['year']))
            $obj->year = $data['year'];

        return $this->qualificationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['diploma_id']))
            $obj->diploma_id = $data['diploma_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['year']))
            $obj->starting_date = $data['year'];

        if (isset($data['option_id']))
            $obj->option_id = $data['option_id'];

        return $this->qualificationRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->qualificationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->qualificationRepository->LatestInserted(Qualification::class);
    }
}
