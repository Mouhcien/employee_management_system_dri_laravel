<?php

namespace App\Http\Controllers;

use App\services\GradeService;
use Illuminate\Http\Request;

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

    public function index() {
        try {

            $grades = $this->gradeService->getAll($this->pages);

            return view('app.grades.index', [
                'grades' => $grades
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->gradeService->create($data);

            if ($result) {
                return redirect()->route('grades.index')->with('success', 'Le grade est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion grade !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $grade = $this->gradeService->getOneById($id);

            if (is_null($grade)) {
                return back()->with('error', 'Grade introuvable !!');
            }

            $result = $this->gradeService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du grade !!');

            return redirect()->route('grades.index')->with('success', 'Le grade est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $grade = $this->gradeService->getOneById($id);

            if (is_null($grade)) {
                return back()->with('error', 'Grade introuvable !!');
            }

            return view('app.grades.show', [
                'grade' => $grade
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $grade = $this->gradeService->getOneById($id);

            if (is_null($grade)) {
                return back()->with('error', 'Grade introuvable !!');
            }

            $result = $this->gradeService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Le grade est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification grade !!!');
            }
        }catch (\Exception $exception) {

        }
    }
}
