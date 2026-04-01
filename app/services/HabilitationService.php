<?php

namespace App\services;

use App\Models\Habilitation;
use App\repositories\HabilitationRepository;

class HabilitationService
{

    private HabilitationRepository $habilitationRepository;

    /**
     * @param HabilitationRepository $habilitationRepository
     */
    public function __construct(HabilitationRepository $habilitationRepository)
    {
        $this->habilitationRepository = $habilitationRepository;
    }

    public function getAll($pages=0){
        return $this->habilitationRepository->All(Habilitation::class, ['user', 'rule'], $pages);
    }

    public function getOneById($id){
        return $this->habilitationRepository->One(Habilitation::class, ['user', 'rule'], $id);
    }

    public function create($data){
        $obj = new Habilitation();

        $obj->profile_id = $data['profile_id'];
        $obj->rule_id = $data['rule_id'];

        return $this->habilitationRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['profile_id']))
            $obj->profile_id = $data['profile_id'];

        if (isset($data['rule_id']))
            $obj->rule_id = $data['rule_id'];

        return $this->habilitationRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->habilitationRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->habilitationRepository->LatestInserted(Habilitation::class);
    }
}
