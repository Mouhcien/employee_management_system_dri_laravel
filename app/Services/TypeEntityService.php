<?php

namespace App\services;

use App\Models\Type;
use App\repositories\TypeEntityRepository;

class TypeEntityService
{
    private TypeEntityRepository $typeEntityRepository;

    /**
     * @param TypeEntityRepository $typeEntityRepository
     */
    public function __construct(TypeEntityRepository $typeEntityRepository)
    {
        $this->typeEntityRepository = $typeEntityRepository;
    }

    public function getAll($pages=0){
        return $this->typeEntityRepository->All(Type::class, ['entities'], $pages);
    }

    public function getOneById($id){
        return $this->typeEntityRepository->One(Type::class, ['entities'], $id);
    }

    public function create($data){
        $obj = new Type();

        $obj->title = $data['title'];

        return $this->typeEntityRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->typeEntityRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->typeEntityRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->typeEntityRepository->LatestInserted(Type::class);
    }
}
