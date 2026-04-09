<?php

namespace App\services;

use App\Models\Training;
use App\repositories\TrainingRepository;

class TrainingService
{
    private TrainingRepository $trainingRepository;

    /**
     * @param TrainingRepository $trainingRepository
     */
    public function __construct(TrainingRepository $trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
    }

    public function getAll($pages=0){
        return $this->trainingRepository->All(Training::class, ['attendences'], $pages);
    }

    public function getOneById($id){
        return $this->trainingRepository->One(Training::class, ['attendences'], $id);
    }

    public function getOneByTitle($title){
        return $this->trainingRepository->OneByTitle(Training::class, ['attendences'], $title);
    }

    public function getAllByFilter($filter, $pages){
        return $this->trainingRepository->AllByFilter($filter, ['attendences'], $pages);
    }

    public function getAllByFilterAndAgent($filter, $agent_id, $pages){
        return $this->trainingRepository->AllByFilterAndAgent($filter, $agent_id, ['attendences'], $pages);
    }


    public function create($data){
        $obj = new Training();

        $obj->title = $data['title'];
        $obj->theme = $data['theme'];
        $obj->starting_date = $data['starting_date'];
        $obj->end_date = $data['end_date'];
        $obj->local = $data['local'];
        $obj->duration = $data['duration'];

        return $this->trainingRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];
        if (isset($data['theme']))
            $obj->theme = $data['theme'];
        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if (isset($data['end_date']))
            $obj->end_date = $data['end_date'];
        if (isset($data['local']))
            $obj->local = $data['local'];
        if (isset($data['duration']))
            $obj->duration = $data['duration'];

        return $this->trainingRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->trainingRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->trainingRepository->LatestInserted(Training::class);
    }
}
