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

    public function index() {
        try {

            $services = $this->occupationService->getAll($this->pages);

            return view('app.occupations.index', [
                'occupations' => $services
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->occupationService->create($data);

            if ($result) {
                return redirect()->route('occupations.index')->with('success', 'La fonction est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion occupation !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $occupation = $this->occupationService->getOneById($id);

            if (is_null($occupation)) {
                return back()->with('error', 'Fonction introuvable !!');
            }

            $result = $this->occupationService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du occupation !!');

            return redirect()->route('occupations.index')->with('success', 'La fonction est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $occupation = $this->occupationService->getOneById($id);

            if (is_null($occupation)) {
                return back()->with('error', 'Fonction introuvable !!');
            }

            return view('app.occupations.show', [
                'occupation' => $occupation
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $occupation = $this->occupationService->getOneById($id);

            if (is_null($occupation)) {
                return back()->with('error', 'Fonction introuvable !!');
            }

            $result = $this->occupationService->update($id, $data);

            if ($result) {
                return back()->with('success', 'La fonction est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification occupation !!!');
            }
        }catch (\Exception $exception) {

        }
    }
}
