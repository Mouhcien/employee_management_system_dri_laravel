<?php

namespace App\repositories;

class MainRepository
{

    public function All($class, $relations, $pages) {
        $query = $class::with($relations)
            ->orderBy('id', 'DESC');

        if ($pages != 0)
            return $query->paginate($pages);

        return $query->get();
    }

    public function One($class, $relations, $id) {
        return $class::with($relations)->find($id);
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
