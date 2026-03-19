<?php

namespace App\Http\Controllers;

use App\services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

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

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->categoryService->create($data);

            if ($result) {
                return redirect()->route('categories.index')->with('success', "La catégorie est bien enregistré !!!");
            }else{
                return back()->with('error', "Erreur insertion catégorie !!");
            }

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
