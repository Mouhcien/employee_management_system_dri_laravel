<?php

namespace App\services;

use App\Models\Classement;
use App\repositories\ClassementRepository;

class ClassementService
{

    private ClassementRepository $classementRepository;
    private $with = ['grade', 'employee'];

    /**
     * @param ClassementRepository $classementRepository
     */
    public function __construct(ClassementRepository $classementRepository)
    {
        $this->classementRepository = $classementRepository;
    }

    public function getAll($pages=0){
        return $this->classementRepository->All(Classement::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->classementRepository->One(Classement::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Classement();

        $obj->grade_id = $data['grade_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->starting_date = $data['starting_date'];

        return $this->classementRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['grade_id']))
            $obj->grade_id = $data['grade_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        if (isset($data['terminated_date']))
            $obj->terminated_date = $data['terminated_date'];

        return $this->classementRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->classementRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->classementRepository->LatestInserted(Classement::class);
    }
}
