<?php

namespace App\services;

use App\Models\Attendence;
use App\repositories\AttendenceRepository;

class AttendenceService
{
    private AttendenceRepository $attendenceRepository;

    /**
     * @param AttendenceRepository $attendenceRepository
     */
    public function __construct(AttendenceRepository $attendenceRepository)
    {
        $this->attendenceRepository = $attendenceRepository;
    }

    public function getAll($pages=0){
        return $this->attendenceRepository->All(Attendence::class, ['training', 'employee'], $pages);
    }

    public function getOneById($id){
        return $this->attendenceRepository->One(Attendence::class, ['training', 'employee'], $id);
    }

    public function create($data){
        $obj = new Attendence();

        $obj->training_id = $data['training_id'];
        $obj->employee_id = $data['employee_id'];
        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if (isset($data['ending_date']))
            $obj->ending_date = $data['ending_date'];

        return $this->attendenceRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['training_id']))
            $obj->trainig_id = $data['training_id'];
        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];
        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if (isset($data['ending_date']))
            $obj->ending_date = $data['ending_date'];

        return $this->attendenceRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->attendenceRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->attendenceRepository->LatestInserted(Attendence::class);
    }
}
