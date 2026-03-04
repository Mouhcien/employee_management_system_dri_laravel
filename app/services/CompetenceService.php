<?php

namespace App\services;

use App\Models\Competence;
use App\repositories\CompetenceRepository;

class CompetenceService
{

    private CompetenceRepository $competenceRepository;
    private $with = ['level', 'employee'];

    /**
     * @param CompetenceRepository $competenceRepository
     */
    public function __construct(CompetenceRepository $competenceRepository)
    {
        $this->competenceRepository = $competenceRepository;
    }

    public function getAll($pages=0){
        return $this->competenceRepository->All(Competence::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->competenceRepository->One(Competence::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Competence();

        $obj->level_id = $data['level_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->grade_id = $data['grade_id'];
        $obj->starting_date = $data['starting_date'];

        return $this->competenceRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['level_id']))
            $obj->level_id = $data['level_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['grade_id']))
            $obj->grade_id = $data['grade_id'];

        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];

        return $this->competenceRepository->Update($obj);
    }

    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->competenceRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->competenceRepository->LatestInserted(Competence::class);
    }
}
