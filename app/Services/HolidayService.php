<?php

namespace App\services;

use App\Models\Holiday;
use App\repositories\HolidayRepository;

class HolidayService
{
    private HolidayRepository $holidayRepository;

    /**
     * @param HolidayRepository $holidayRepository
     */
    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    public function getAll($pages=0){
        return $this->holidayRepository->All(Holiday::class, ['employee'], $pages);
    }

    public function getOneById($id){
        return $this->holidayRepository->One(Holiday::class, ['employee'], $id);
    }

    public function create($data){
        $obj = new Holiday();

        $obj->year = $data['year'];
        if (isset($data['total_year']))
            $obj->total_year = $data['total_year'];
        if (isset($data['total_rest']))
            $obj->total_rest = $data['total_rest'];
        $obj->demand = $data['demand'];
        $obj->starting_date = $data['starting_date'];
        $obj->employee_id = $data['employee_id'];

        return $this->holidayRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['total_year']))
            $obj->year = $data['year'];
        if (isset($data['total_year']))
            $obj->total_year = $data['total_year'];
        if (isset($data['total_rest']))
            $obj->total_rest = $data['total_rest'];
        if (isset($data['demand']))
            $obj->demand = $data['demand'];
        if (isset($data['starting_date']))
            $obj->starting_date = $data['starting_date'];
        if (isset($data['employee_id']))
            $obj->employee_id = $data['employee_id'];

        return $this->holidayRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->holidayRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->holidayRepository->LatestInserted(Holiday::class);
    }

}
