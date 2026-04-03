<?php

namespace App\Http\Controllers;

use App\services\CategoryService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    private EmployeeService $employeeService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService, EmployeeService $employeeService)
    {
        $this->categoryService = $categoryService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll($this->pages);
        $employees = $this->employeeService->getAll(0);

        return view('app.categories.index', [
            'categories' => $categories,
            'employee_total' => $employees->count()
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

    public function show(Request $request, $id) {
        try {

            $this->pages = $this->setEmployeeCardSession($request);

            $category = $this->categoryService->getOneById($id);

            $employees = $this->employeeService->getAllByCategory($id, $this->pages);

            $employeeObj = null;
            if ($request->has('emp')) {
                $employee_id = $request->query('emp');
                $employeeObj = $this->employeeService->getOneById($employee_id);
            }

            if (is_null($category)){
                return back()->with('error', 'Categorie introuvable');
            }

            return view('app.categories.show', [
                'category' => $category,
                'employees' => $employees,
                'employeeObj' => $employeeObj
            ]);

        }catch (\Exception $exception) {
            return back()->with('erropr', $exception->getMessage());
        }
    }

}
