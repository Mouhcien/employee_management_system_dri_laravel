<?php

namespace App\services;

use App\Models\Grade;
use App\repositories\GradeRepository;

class GradeService
{
    private GradeRepository $gradeRepository;

    /**
     * @param GradeRepository $gradeRepository
     */
    public function __construct(GradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    public function getAll($pages=0){
        return $this->gradeRepository->All(Grade::class, ['classements'], $pages);
    }

    public function getOneById($id){
        return $this->gradeRepository->One(Grade::class, ['classements'], $id);
    }

    public function create($data){
        $obj = new Grade();

        $obj->title = $data['title'];

        return $this->gradeRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->gradeRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->gradeRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->gradeRepository->LatestInserted(Grade::class);
    }
}
