<?php

namespace App\services;

use App\Models\Category;
use App\repositories\CategoryRepository;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll($pages=0){
        return $this->categoryRepository->All(Category::class, ['employees'], $pages);
    }

    public function getOneById($id){
        return $this->categoryRepository->One(Category::class, ['employees'], $id);
    }

    public function create($data){
        $obj = new Category();

        $obj->title = $data['title'];

        return $this->categoryRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->categoryRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->categoryRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->categoryRepository->LatestInserted(Category::class);
    }
}
