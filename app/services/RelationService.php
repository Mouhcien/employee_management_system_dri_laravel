<?php

namespace App\services;

use App\Models\Relation;
use App\repositories\RelationRepository;

class RelationService
{

    private RelationRepository $relationRepository;
    private $with = ['table', 'column'];

    /**
     * @param RelationRepository $relationRepository
     */
    public function __construct(RelationRepository $relationRepository)
    {
        $this->relationRepository = $relationRepository;
    }

    public function getAll($pages=0){
        return $this->relationRepository->All(Relation::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->relationRepository->One(Relation::class, $this->with, $id);
    }

    public function getRelationWhichColumnNotInNewList($table_id, $submittedColumnIds){
        return $this->relationRepository->getRelationWhichColumnNotInNewList($table_id, $submittedColumnIds);
    }

    public function create($data){
        $obj = new Relation();

        $obj->table_id = $data['table_id'];
        $obj->column_id = $data['column_id'];

        return $this->relationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['table_id']))
            $obj->table_id = $data['table_id'];

        if (isset($data['column_id']))
            $obj->column_id = $data['column_id'];

        return $this->relationRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->relationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->relationRepository->LatestInserted(Relation::class);
    }
}
