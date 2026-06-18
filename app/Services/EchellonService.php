<?php

namespace App\services;

use App\Models\Echellon;
use App\repositories\EchellonRepository;

class EchellonService
{
    private EchellonRepository $echellonRepository;

    /**
     * @param EchellonRepository $echellonRepository
     */
    public function __construct(EchellonRepository $echellonRepository)
    {
        $this->echellonRepository = $echellonRepository;
    }

    public function getAll($pages=0){
        return $this->echellonRepository->All(Echellon::class, ['remunerations'], $pages);
    }

    public function getOneById($id){
        return $this->echellonRepository->One(Echellon::class, ['remunerations'], $id);
    }

    public function create($data){
        $obj = new Echellon();

        $obj->title = $data['title'];

        return $this->echellonRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->echellonRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->echellonRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->echellonRepository->LatestInserted(Echellon::class);
    }
}
