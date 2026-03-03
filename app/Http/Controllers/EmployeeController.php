<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\EmployeeService;
use App\services\LocalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;
    private LocalService $localService;
    private CityService $cityService;
    private $pages = 10;
    private $rules = [
        'ppr' => 'required',
        'cin' => 'required',
        'firstname' => 'required',
        'lastname' => 'required',
        'local_id' => 'required'
    ];

    /**
     * @param EmployeeService $employeeService
     * @param LocalService $localService
     * @param CityService $cityService
     */
    public function __construct(EmployeeService $employeeService, LocalService $localService, CityService $cityService)
    {
        $this->employeeService = $employeeService;
        $this->localService = $localService;
        $this->cityService = $cityService;
    }


    public function index() {

        $locals = $this->localService->getAll(0);
        $employees = $this->employeeService->getAll($this->pages);
        $male_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'M'], 0);
        $female_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'F'], 0);
        $cities = $this->cityService->getAll(0);

        return view('app.employees.index', [
            'locals' => $locals,
            'employees' => $employees,
            'cities' => $cities,
            'femaleCount' => $female_employees->count(),
            'maleCount' => $male_employees->count()
        ]);
    }

    public function create(){
        try {
            $locals = $this->localService->getAll(0);

            return view('app.employees.insert', [
                'locals' => $locals
            ]);

        }catch (\Exception $exception) {

        }
    }

    public function store(Request $request){
        try {

            $data = $request->validate($this->rules);

            $data['firstname_arab'] = $request->input('firstname_arab');
            $data['lastname_arab'] = $request->input('lastname_arab');
            $data['birth_date'] = $request->input('birth_date');
            $data['birth_city'] = $request->input('birth_city');
            $data['gender'] = $request->input('gender');
            $data['sit'] = $request->input('sit');
            $data['hiring_date'] = $request->input('hiring_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');
            $data['status'] = 1; //actif

            $data['photo'] = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                $filename = time() . '_' . $data['lastname'] . '_' . $data['firstname'] . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }

            $result = $this->employeeService->create($data);

            if ($result) {
                return redirect()->route('employees.index')->with('success', 'Employée est bien ajouté !!!');
            }

            return back()->with('error', 'Erreur insertion employé');


        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit($id){
        try {
            $locals = $this->localService->getAll(0);
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            return view('app.employees.insert', [
                'locals' => $locals,
                'employee' => $employee
            ]);

        }catch (\Exception $exception) {

        }
    }

    public function update(Request $request, $id){
        try {

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $data = $request->validate($this->rules);

            $data['firstname_arab'] = $request->input('firstname_arab');
            $data['lastname_arab'] = $request->input('lastname_arab');
            $data['birth_date'] = $request->input('birth_date');
            $data['birth_city'] = $request->input('birth_city');
            $data['gender'] = $request->input('gender');
            $data['sit'] = $request->input('sit');
            $data['hiring_date'] = $request->input('hiring_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');


            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                $filename = time() . '_' . $data['lastname'] . '_' . $data['firstname'] . '-' . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }

            $result = $this->employeeService->update($id, $data);

            if ($result) {
                return redirect()->route('employees.index')->with('success', 'Employée est bien modifié !!!');
            }

            return back()->with('error', 'Erreur insertion employé');


        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id){
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $result = $this->employeeService->delete($id);

            if ($result) {
                if (!is_null($employee->photo)) {
                    Storage::disk('public')->delete($employee->photo);
                }
                return back()->with('success', 'Employé est supprimé avec success');
            }

            return back()->with('error', 'Erreur suppression employé');

        }catch (\Exception $exception) {

        }
    }

    public function show($id){
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            return view('app.employees.show', [
                'employee' => $employee
            ]);

        }catch (\Exception $exception) {

        }
    }
}
