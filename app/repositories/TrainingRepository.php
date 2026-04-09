<?php

namespace App\repositories;

use App\Models\Training;

class TrainingRepository extends MainRepository
{

    public function AllByFilter($filter, $with, $pages) {
        $query = Training::with($with)
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('starting_date', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllByFilterAndAgent($filter, $agent_id, $with, $pages) {
        $query = Training::with($with)
            ->join('attendences' ,'attendences.training_id' , 'trainings.id')
            ->where('attendences.employee_id', '=', $agent_id)
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('starting_date', 'DESC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }
}
