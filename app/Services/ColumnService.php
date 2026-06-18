<?php

namespace App\services;

use App\Models\Column;
use App\repositories\ColumnRepository;

class ColumnService
{

    private ColumnRepository $columnRepository;
    private $with = ['relations'];

    /**
     * @param ColumnRepository $columnRepository
     */
    public function __construct(ColumnRepository $columnRepository)
    {
        $this->columnRepository = $columnRepository;
    }

    public function getAll($pages=0){
        return $this->columnRepository->All(Column::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->columnRepository->One(Column::class, $this->with, $id);
    }

    public function getAllColumnsByTable($table_id){
        return $this->columnRepository->AllColumnsByTable($table_id, $this->with);
    }

    public function create($data){
        $obj = new Column();

        $obj->title = str_replace(' ', '_', $data['title']);

        if (isset($data['description']))
            $obj->description = $data['description'];

        return $this->columnRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        if (isset($data['description']))
            $obj->description = $data['description'];

        return $this->columnRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->columnRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->columnRepository->LatestInserted(Column::class);
    }
}
