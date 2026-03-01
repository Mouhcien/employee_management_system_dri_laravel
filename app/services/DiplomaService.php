<?php

namespace App\services;

use App\Models\Diploma;
use App\repositories\DiplomaRepository;

class DiplomaService
{
    private DiplomaRepository $diplomaRepository;

    /**
     * @param DiplomaRepository $diplomaRepository
     */
    public function __construct(DiplomaRepository $diplomaRepository)
    {
        $this->diplomaRepository = $diplomaRepository;
    }

    public function getAll($pages=0){
        return $this->diplomaRepository->All(Diploma::class, ['qualifications'], $pages);
    }

    public function getOneById($id){
        return $this->diplomaRepository->One(Diploma::class, ['qualifications'], $id);
    }

    public function create($data){
        $obj = new Diploma();

        $obj->title = $data['title'];

        return $this->diplomaRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->diplomaRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->diplomaRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->diplomaRepository->LatestInserted(Diploma::class);
    }
}
