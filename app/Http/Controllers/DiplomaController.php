<?php

namespace App\Http\Controllers;

use App\services\DiplomaService;
use Illuminate\Http\Request;

class DiplomaController extends Controller
{
    private DiplomaService $diplomaService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param DiplomaService $diplomaService
     */
    public function __construct(DiplomaService $diplomaService)
    {
        $this->diplomaService = $diplomaService;
    }

    public function index()
    {
        $diplomas = $this->diplomaService->getAll($this->pages);

        return view('app.education.diplomas.index', [
            'diplomas' => $diplomas
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->diplomaService->create($data)) {
            return redirect()->route('settings')->with('success', 'Le diplôme est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion diplôme !!!');
    }

    public function show($id)
    {
        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'Type introuvable !!');
        }

        return view('app.education.diplomas.show', [
            'diploma' => $diploma
        ]);
    }

    public function delete($id)
    {
        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'Type introuvable !!');
        }

        if (is_null($this->diplomaService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du diplôme !!');
        }

        return redirect()->route('settings')->with('success', 'Le diplôme est bien supprimé');
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'diplôme introuvable !!');
        }

        if ($this->diplomaService->update($id, $data)) {
            return back()->with('success', 'Le diplôme est bien modifier');
        }

        return back()->with('error', 'Erreur midification diplôme !!!');
    }
}
