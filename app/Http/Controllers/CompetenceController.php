<?php

namespace App\Http\Controllers;

use App\services\CompetenceService;
use App\Services\EmployeeService;
use App\services\GradeService;
use App\services\LevelService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompetenceController extends Controller
{
    private CompetenceService $competenceService;
    private LevelService $levelService;
    private GradeService $gradeService;
    private EmployeeService $employeeService;
    private $rules = [
        'employee_id' => 'required',
        'level_id' => 'required',
        'grade_id' => 'required',
        'starting_date' => 'required'
    ];

    /**
     * @param CompetenceService $competenceService
     */
    public function __construct(CompetenceService $competenceService,
                                LevelService $levelService,
                                GradeService $gradeService,
                                EmployeeService $employeeService)
    {
        $this->competenceService = $competenceService;
        $this->levelService = $levelService;
        $this->gradeService = $gradeService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->competenceService->create($data)) {
            return back()->with('success', 'La competance est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion competance');
    }

    public function importation(Request $request)
    {

        if ($request->hasFile('file_competence')) {

            $request->validate([
                'file_competence' => 'required|file|mimes:xlsx,csv,xls'
            ]);

            // Read data into array
            $rows = Excel::toArray([], $request->file('file_competence'));

            $count = 0;
            foreach ($rows[0] as $rr) {
                $employee = $this->employeeService->getOneByPPR($rr[0]);

                $data['grade_id'] = $rr[1];
                $grade = $this->gradeService->getOneById($rr[1]);
                if (!is_null($grade)) {
                    $space_count = substr_count($grade->title, ' ');
                    $parts = explode(" ", $grade->title);
                    $level_title = "";
                    if ($space_count == 2) {
                        $level_title = strtoupper($parts[0]);
                    } elseif ($space_count > 2) {
                        $level_title = strtoupper($parts[0] . " " . $parts[1]);
                    } else {
                        $level_title = strtoupper($grade->title);
                    }

                    $level = $this->levelService->getOneByTitle($level_title);

                    if (!is_null($level)) {

                        $data['level_id'] = $level->id;
                        $data['employee_id'] = $employee->id;

                        $this->competenceService->create($data);
                        $count++;
                    }
                }
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
        $competence = $this->competenceService->getOneById($id);
        if (is_null($competence))
            return back()->with('error', 'Grade Introuvable !!');

        $result = $this->competenceService->delete($id);

        if ($result)
            return back()->with('success', 'La suppression du grade est bien faite !!');
        else
            return back()->with('error', 'Erreur lors de la suppression du grade !!!');
    }
}
