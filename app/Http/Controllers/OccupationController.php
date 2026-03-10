<?php

namespace App\Http\Controllers;

use App\services\OccupationService;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    private OccupationService $occupationService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param OccupationService $occupationService
     */
    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    public function index()
    {
        $services = $this->occupationService->getAll($this->pages);

        return view('app.occupations.index', [
            'occupations' => $services
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->occupationService->create($data)) {
            return redirect()->route('occupations.index')->with('success', 'La fonction est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion occupation !!!');
    }

    public function delete($id)
    {
        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        if (is_null($this->occupationService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du occupation !!');
        }

        return redirect()->route('occupations.index')->with('success', 'La fonction est bien supprimé');
    }

    public function show($id)
    {
        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        return view('app.occupations.show', [
            'occupation' => $occupation
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        if ($this->occupationService->update($id, $data)) {
            return back()->with('success', 'La fonction est bien modifier');
        }

        return back()->with('error', 'Erreur midification occupation !!!');
    }
}
