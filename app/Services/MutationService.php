<?php

namespace App\services;

use App\Models\Mutation;
use App\repositories\MutationRepository;

class MutationService
{
    private MutationRepository $mutationRepository;
    private $with = ['fromAffectation', 'toAffectation', 'employee', 'demand'];

    /**
     * @param MutationRepository $mutationRepository
     */
    public function __construct(MutationRepository $mutationRepository)
    {
        $this->mutationRepository = $mutationRepository;
    }

    public function getAll($pages=0){
        return $this->mutationRepository->All(Mutation::class, $this->with, $pages);
    }

    public  function getAllByFilter($filter, $pages) {
        return $this->mutationRepository->AllByFilter($filter, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->mutationRepository->One(Mutation::class, $this->with, $id);
    }

    public function getOneByTitle($title){
        return $this->mutationRepository->OneByTitle(Mutation::class, $this->with, $title);
    }

    public function create($data){
        $obj = new Mutation();

        $obj->employee_id = $data['employee_id'];
        $obj->from_affectation_id = $data['from_affectation_id'];
        if ( isset($data['to_affectation_id']))
            $obj->to_affectation_id = $data['to_affectation_id'];
        if ( isset($data['entity_name']))
            $obj->entity_name = $data['entity_name'];
        if ( isset($data['direction_name']))
            $obj->direction_name = $data['direction_name'];
        if ( isset($data['city_name']))
            $obj->city_name = $data['city_name'];
        if ( isset($data['type']))
            $obj->type = $data['type'];
        if ( isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if ( isset($data['ref']))
            $obj->ref = $data['ref'];
        if ( isset($data['category_name']))
            $obj->category_name = $data['category_name'];
        if ( isset($data['demand_id']))
            $obj->demand_id = $data['demand_id'];

        return $this->mutationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        $obj->employee_id = $data['employee_id'];
        $obj->from_affectation_id = $data['from_affectation_id'];
        if ( isset($data['to_affectation_id']))
            $obj->to_affectation_id = $data['to_affectation_id'];
        if ( isset($data['entity_name']))
            $obj->entity_name = $data['entity_name'];
        if ( isset($data['direction_name']))
            $obj->direction_name = $data['direction_name'];
        if ( isset($data['city_name']))
            $obj->city_name = $data['city_name'];
        if ( isset($data['type']))
            $obj->type = $data['type'];
        if ( isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if ( isset($data['ref']))
            $obj->ref = $data['ref'];
        if ( isset($data['category_name']))
            $obj->category_name = $data['category_name'];
        if ( isset($data['demand_id']))
            $obj->demand_id = $data['demand_id'];

        return $this->mutationRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->mutationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->mutationRepository->LatestInserted(Mutation::class);
    }

}
