<?php

namespace App\Http\Controllers;

use App\services\DemandService;
use App\Services\EmployeeService;
use App\services\MutationService;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    private DemandService $demandService;
    private MutationService $mutationService;
    private EmployeeService $employeeService;

    private $pages = 10;

    private $rules = [
        'title' => 'required',
        'object' => 'required',
        'demand_date' => 'required',
        'type' => 'required',
        'employee_id' => 'required',
    ];

    /**
     * @param DemandService $demandService
     * @param MutationService $mutationService
     * @param EmployeeService $employeeService
     */
    public function __construct(DemandService $demandService, MutationService $mutationService, EmployeeService $employeeService)
    {
        $this->demandService = $demandService;
        $this->mutationService = $mutationService;
        $this->employeeService = $employeeService;
    }

    public function index(Request $request) {
        try {

            $demands = $this->demandService->getAll($this->pages);
            $employees = $this->employeeService->getAll(0);

            return view('app.demands.index', [
                'demands' => $demands,
                'employees' => $employees
            ]);


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create() {
        try {

            $employees = $this->employeeService->getAll(0);

            return view('app.demands.insert', [
                'employees' => $employees
            ]);


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $filename = $data['employee_id'].".".$file->extension();
                $path = $file->storeAs('files/demands/employees', $filename, 'public');

                $data['file'] = $path;
            }

            $result = $this->demandService->create($data);

            if ($result) {
                return redirect()->route('demands.index')->with('success', "Demande est bien enregistré !!");
            }

            return back()->with('error', "Erreur lors de l'enregistrement du demandes !!!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id) {
        try {

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id) {
        try {

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
