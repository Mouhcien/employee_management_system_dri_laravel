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

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->diplomaService->create($data);

            if ($result) {
                return redirect()->route('settings')->with('success', 'Le diplôme est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion diplôme !!!');
            }
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $diploma = $this->diplomaService->getOneById($id);

            if (is_null($diploma)) {
                return back()->with('error', 'Type introuvable !!');
            }

            $result = $this->diplomaService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du diplôme !!');

            return redirect()->route('settings')->with('success', 'Le diplôme est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }


    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $diploma = $this->diplomaService->getOneById($id);

            if (is_null($diploma)) {
                return back()->with('error', 'diplôme introuvable !!');
            }

            $result = $this->diplomaService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Le diplôme est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification diplôme !!!');
            }
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
