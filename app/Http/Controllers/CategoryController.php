<?php

namespace App\Http\Controllers;

use App\services\CategoryService;
use App\Services\EmployeeService;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function load(Request $request, $id) {
        try {

            $year = $request->txt_year;
            $gross = $request->txt_gross;
            $ir = $request->txt_ir;
            $net = $request->txt_net;
            $words = $request->txt_words;

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $grade = is_null($employee->competences->where('finished_date', null)->first()) ? 'N/A' : $employee->competences->where('finished_date', null)->first()->grade->title;
            $civility = $employee->gender == 'M' ? 'M' : 'Mme';

            $pdf = Pdf::loadView('app.employees.certificates.bonus-certificate', [
                'employee' => $employee,
                'grade' => $grade,
                'civility' => $civility,
                'year' => $year,
                'gross' => $gross,
                'ir' => $ir,
                'net' => $net,
                'words' => $words,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream();

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
