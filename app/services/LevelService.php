<?php

namespace App\services;

use App\Models\Level;
use App\repositories\LevelRepository;

class LevelService
{
    private LevelRepository $levelRepository;

    /**
     * @param LevelRepository $levelRepository
     */
    public function __construct(LevelRepository $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    public function getAll($pages=0){
        return $this->levelRepository->All(Level::class, ['competences'], $pages);
    }

    public function getOneById($id){
        return $this->levelRepository->One(Level::class, ['competences'], $id);
    }

    public function create($data){
        $obj = new Level();

        $obj->title = $data['title'];

        return $this->levelRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->levelRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->levelRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->levelRepository->LatestInserted(Level::class);
    }
}
