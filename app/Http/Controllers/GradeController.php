<?php

namespace App\Http\Controllers;

use App\Exports\GradeExport;
use App\Exports\OccupationExport;
use App\services\GradeService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{
    private GradeService $gradeService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'scale' => 'required'
    ];

    /**
     * @param GradeService $gradeService
     */
    public function __construct(GradeService $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    public function index(Request $request)
    {
        $grades = $this->gradeService->getAll($this->pages);

        $value = "";
        if ($request->has('q')){
            $value = $request->query('q');
            $grades = $this->gradeService->getAllByfilter($value, $this->pages);
        }

        return view('app.grades.index', [
            'grades' => $grades,
            'value' => $value
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->gradeService->create($data)) {
            return redirect()->route('grades.index')->with('success', 'Le grade est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion grade !!!');
    }

    public function delete($id)
    {
        $grade = $this->gradeService->getOneById($id);

        if (is_null($grade)) {
            return back()->with('error', 'Grade introuvable !!');
        }

        if (is_null($this->gradeService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du grade !!');
        }

        return redirect()->route('grades.index')->with('success', 'Le grade est bien supprimé');
    }

    public function show($id)
    {
        $grade = $this->gradeService->getOneById($id);

        if (is_null($grade)) {
            return back()->with('error', 'Grade introuvable !!');
        }

        return view('app.grades.show', [
            'grade' => $grade
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $grade = $this->gradeService->getOneById($id);

        if (is_null($grade)) {
            return back()->with('error', 'Grade introuvable !!');
        }

        if ($this->gradeService->update($id, $data)) {
            return back()->with('success', 'Le grade est bien modifier');
        }

        return back()->with('error', 'Erreur midification grade !!!');
    }

    public function download($id = null) {
        try {
            $data = [];

            if (is_null($id)) {
                $grades = $this->gradeService->getAll(0);
                foreach ($grades as $grade) {
                    $data = array_merge($data, $this->getDataExport($grade));
                }
            } else {
                $grade = $this->gradeService->getOneById($id);
                if (!$grade) return back()->with('error', 'Grade introuvable !!');
                $data = $this->getDataExport($grade);
            }

            $current_date = (new DateTime())->format('Y-m-d_H-i-s');
            return Excel::download(new GradeExport($data), "Grades_DRI-Marrakech_{$current_date}.xlsx");

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    private function getDataExport($grade) {
        $data = [];

        foreach ($grade->competences as $competence) {
            if (is_null($competence->finished_date)) {
                $employee = $competence->employee;

                $activeAffectation = $employee?->affectations->where('state', '1')->first();

                $row = [
                    $grade->id,                                  // 0
                    $grade->title,                               // 1
                    $competence->level->title ?? '',             // 2
                    $employee->ppr ?? '',                        // 3
                    $employee->cin ?? '',                        // 4
                    $employee->lastname ?? '',                   // 5
                    $employee->firstname ?? '',                  // 6
                    $employee->lastname_arab ?? '',              // 7
                    $employee->firstname_arab ?? '',              // 8
                    $employee->email ?? '',                      // 9
                    $activeAffectation?->service?->title ?? '',  // 10
                    $activeAffectation?->entity?->title ?? '',   // 11
                    $activeAffectation?->sector?->title ?? '',   // 12
                    $activeAffectation?->section?->title ?? '',  // 13
                ];

                $data[] = $row;
            }
        }
        return $data;
    }
}
