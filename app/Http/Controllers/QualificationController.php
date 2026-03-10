<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\services\QualificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class QualificationController extends Controller
{
    private QualificationService $qualificationService;
    private EmployeeService $employeeService;
    private $rules = [
        'employee_id' => 'required',
        'diploma_id' => 'required'
    ];

    /**
     * @param QualificationService $qualificationService
     */
    public function __construct(QualificationService $qualificationService, EmployeeService $employeeService)
    {
        $this->qualificationService = $qualificationService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->qualificationService->create($data)) {
            return back()->with('success', 'Le dipôme est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion dipôme');
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

                $data['diploma_id'] = $request->input('diploma_id');
                $data['option_id'] = $request->input('option_id');
                $data['employee_id'] = $employee->id;

                $this->qualificationService->create($data);
                $count++;
            }

            if ($count == count($rows[0])) {
                return redirect()->route('employees.index')->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
            } else {
                return redirect()->route('employees.index')->with('error', "diplômes sont ajouté " . $count . "/" . count($rows[0]) . " !");
            }

        } else {
            return redirect()->route('employees.import')->with('error', "Merci de spécifier le fichier excel contenant les employés avec les diplômes");
        }
    }
}
