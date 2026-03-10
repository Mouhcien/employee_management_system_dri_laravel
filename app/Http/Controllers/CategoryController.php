<?php

namespace App\Http\Controllers;

use App\services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    private $pages = 10;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll($this->pages);

        return view('app.categories.index', [
            'categories' => $categories
        ]);
    }

}
