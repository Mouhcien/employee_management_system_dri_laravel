<?php

namespace App\repositories;

use App\Models\Employee;
use App\Models\Period;

class MainRepository
{

    public function All($class, $relations, $pages) {
        $query = $class::with($relations);

        if ($class === Employee::class) {
            $query->where('employees.status', '=', 1);
            $query->orderBy('employees.lastname', 'ASC');
        }


        if ($class === Period::class)
            $query->orderBy('periods.year', 'DESC')->orderBy('periods.title', 'ASC');

        $query->orderBy('id', 'DESC');

        if ($pages != 0)
            return $query->paginate($pages);

        return $query->get();
    }

    public function One($class, $relations, $id) {
        return $class::with($relations)->find($id);
    }

    public function OneByTitle($class, $relations, $title) {
        return $class::with($relations)->where('title', '=', $title)->first();
    }

    public function Add($object) {
        return $object->save();
    }

    public function Update($object) {
        return $object->save();
    }

    public function Delete($object) {
        return $object->delete();
    }

    public function LatestInserted($class) {
        return $class::latest('id')->first()->id;
    }

}
