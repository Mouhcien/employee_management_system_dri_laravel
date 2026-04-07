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
        'diploma_id' => 'required',
        'option_id' => 'required'
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
        $data['year'] = $request->input('year');

        if ($this->qualificationService->create($data)) {
            return back()->with('success', 'Le dipôme est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion dipôme');
    }

    public function update(Request $request, $id)
    {
        $qualification = $this->qualificationService->getOneById($id);
        if (is_null($qualification))
            return back()->with('error', 'Diplôme introuvable !!');

        $data = $request->validate($this->rules);
        $data['year'] = $request->input('year');

        if ($this->qualificationService->update($id, $data)) {
            return back()->with('success', 'Le diplôme est bien modifié');
        }

        return back()->with('error', 'Erreur mise à jour dipôme');
    }

    public function importation(Request $request)
    {
        if ($request->hasFile('file_qualification')) {

            $request->validate([
                'file_qualification' => 'required|file|mimes:xlsx,csv,xls'
            ]);

            // Read data into array
            $rows = Excel::toArray([], $request->file('file_qualification'));

            $count = 0;
            foreach ($rows[0] as $rr) {
                $employee = $this->employeeService->getOneByPPR($rr[0]);

                $data['diploma_id'] = $rr[1];

                if ($rr[2] == "" || $rr[2] == null)
                    $data['option_id'] = null;
                else
                    $data['option_id'] = $rr[2];

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
            return redirect()->route('settings.importation')->with('error', "Merci de spécifier le fichier excel contenant les employés avec les diplômes");
        }
    }

    public function delete($id)
    {
        $qualification = $this->qualificationService->getOneById($id);
        if (is_null($qualification))
            return back()->with('error', "Qualification est diplôme introuvable !!");

        $result = $this->qualificationService->delete($id);

        if ($result)
            return back()->with('success', "La suppression est bien faite !!!");
        else
            return back()->with('error', "Erreur lors de l'opération de suppression !!!");
    }
}
