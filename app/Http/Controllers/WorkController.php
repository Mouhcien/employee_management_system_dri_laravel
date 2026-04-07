<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\services\WorkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class WorkController extends Controller
{

    private WorkService $workService;
    private EmployeeService $employeeService;
    private $rules = [
        'employee_id' => 'required',
        'occupation_id' => 'required',
    ];

    /**
     * @param WorkService $workService
     */
    public function __construct(WorkService $workService, EmployeeService $employeeService)
    {
        $this->workService = $workService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->workService->create($data)) {
            return back()->with('success', 'La fonction est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion fonction');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $work = $this->workService->getOneById($id);
        if (is_null($work))
            return back()->with('error', 'fonction introuvable');

        $employee = $this->employeeService->getOneById($data['employee_id']);
        if (is_null($employee))
            return back()->with('error', 'Agent introuvable');

        $data['starting_date'] = $request->starting_date;

        $result = $this->workService->update($id, $data);

        if ($result) {
            return back()->with('success', 'Fonction est bien changé !!');
        }

        return back()->with('error', 'Erreur lors de la mise à jour de la fonction');
    }

    public function importation(Request $request)
    {
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|file|mimes:xlsx,csv,xls'
            ]);

            // Read data into array
            $rows = Excel::toArray([], $request->file('file'));

            $count = 0;
            foreach ($rows[0] as $rr) {
                $employee = $this->employeeService->getOneByPPR($rr[0]);

                $data['occupation_id'] = $request->input('occupation_id');
                $data['employee_id'] = $employee->id;

                $this->workService->create($data);
                $count++;
            }

            if ($count == count($rows[0])) {
                return redirect()->route('employees.index')->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
            } else {
                return redirect()->route('employees.index')->with('error', "Employé sont ajouté " . $count . "/" . count($rows[0]) . " !");
            }

        } else {
            return redirect()->route('employees.import')->with('error', "Merci de spécifier le fichier excel contenant les employés");
        }
    }
}
