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

    public function index()
    {
        $grades = $this->gradeService->getAll($this->pages);

        return view('app.grades.index', [
            'grades' => $grades
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
}
