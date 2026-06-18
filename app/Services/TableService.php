<?php

namespace App\services;

use App\Models\Table;
use App\repositories\TableRepository;

class TableService
{
    private TableRepository $tableRepository;
    private $with = ['relations'];

    /**
     * @param TableRepository $tableRepository
     */
    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    public function getAll($pages=0){
        return $this->tableRepository->All(Table::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->tableRepository->One(Table::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Table();

        $obj->title = str_replace(' ', '_', $data['title']);

        if (isset($data['description']))
            $obj->description = $data['description'];

        return $this->tableRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        if (isset($data['description']))
            $obj->description = $data['description'];

        return $this->tableRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->tableRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->tableRepository->LatestInserted(Table::class);
    }
}
