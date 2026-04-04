<?php

namespace App\services;

use App\Models\Value;
use App\repositories\ValueRepository;

class ValueService
{

    private ValueRepository $valueRepository;
    private $with = ['relation', 'employee', 'period'];

    /**
     * @param ValueRepository $valueRepository
     */
    public function __construct(ValueRepository $valueRepository)
    {
        $this->valueRepository = $valueRepository;
    }

    public function getAll($pages=0){
        return $this->valueRepository->All(Value::class, $this->with, $pages);
    }

    public function getAllByTable($table_id, $pages=0){
        return $this->valueRepository->AllByTable($table_id, $this->with, $pages);
    }

    public function getAllByPeriod($period_id, $pages=0){
        return $this->valueRepository->AllByPeriod($period_id, $this->with, $pages);
    }

    public function getAllByEmployee($employee_id, $pages=0){
        return $this->valueRepository->AllByEmployee($employee_id, $this->with, $pages);
    }

    public function getAllByService($service_id){
        return $this->valueRepository->getAllByService($service_id, $this->with);
    }

    public function getAllByEntity($entity_id){
        return $this->valueRepository->getAllByEntity($entity_id, $this->with);
    }

    public function getAllBySector($sector_id){
        return $this->valueRepository->getAllBySector($sector_id, $this->with);
    }

    public function getAllBySection($section_id){
        return $this->valueRepository->getAllBySection($section_id, $this->with);
    }

    public function getAllByServiceWithEmployees($service_id, $table_id, $period_id){
        return $this->valueRepository->getAllByServiceWithEmployees($service_id, $table_id, $period_id);
    }

    public function getAllByEntityWithEmployees($entity_id, $table_id, $period_id){
        return $this->valueRepository->getAllByEntityWithEmployees($entity_id, $table_id, $period_id);
    }

    public function getAllBySectorWithEmployees($sector_id, $table_id, $period_id){
        return $this->valueRepository->getAllBySectorWithEmployees($sector_id, $table_id, $period_id);
    }

    public function getAllBySectionWithEmployees($section_id, $table_id, $period_id){
        return $this->valueRepository->getAllBySectionWithEmployees($section_id, $table_id, $period_id);
    }

    public function getAllByFilters($filter, $pages=0){
        return $this->valueRepository->AllByFilter($filter, $this->with, $pages);
    }

    public function getAllByIds($values_id){
        return $this->valueRepository->AllByIds($values_id, $this->with);
    }

    public function getOneById($id){
        return $this->valueRepository->One(Value::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Value();

        $obj->relation_id = $data['relation_id'];
        $obj->employee_id = $data['employee_id'];
        $obj->period_id = $data['period_id'];
        $obj->value = $data['value'];

        return $this->valueRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['relation_id']))
            $obj->relation_id = $data['relation_id'];

        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        if (isset($data['period_id']))
            $obj->period_id = $data['period_id'];

        if (isset($data['value']))
            $obj->value = $data['value'];

        return $this->valueRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->valueRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->valueRepository->LatestInserted(Value::class);
    }
}
