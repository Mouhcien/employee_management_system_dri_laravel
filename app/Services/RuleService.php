<?php

namespace App\services;

use App\Models\Rule;
use App\repositories\RuleRepository;

class RuleService
{
    private RuleRepository $ruleRepository;

    /**
     * @param RuleRepository $ruleRepository
     */
    public function __construct(RuleRepository $ruleRepository)
    {
        $this->ruleRepository = $ruleRepository;
    }

    public function getAll($pages=0){
        return $this->ruleRepository->All(Rule::class, ['habilitations'], $pages);
    }

    public function getOneById($id){
        return $this->ruleRepository->One(Rule::class, ['habilitations'], $id);
    }

    public function create($data){
        $obj = new Rule();

        $obj->title = $data['title'];

        return $this->ruleRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->ruleRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->ruleRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->ruleRepository->LatestInserted(Rule::class);
    }
}
