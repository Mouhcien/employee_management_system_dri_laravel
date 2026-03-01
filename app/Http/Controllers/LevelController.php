<?php

namespace App\Http\Controllers;

use App\services\LevelService;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    private LevelService $levelService;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param LevelService $levelService
     */
    public function __construct(LevelService $levelService)
    {
        $this->levelService = $levelService;
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->levelService->create($data);

            if ($result) {
                return redirect()->route('settings')->with('success', 'Le niveau est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion niveau !!!');
            }
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $level = $this->levelService->getOneById($id);

            if (is_null($level)) {
                return back()->with('error', 'Niveau introuvable !!');
            }

            $result = $this->levelService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du niveau !!');

            return redirect()->route('settings')->with('success', 'Le niveau est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }


    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $level = $this->levelService->getOneById($id);

            if (is_null($level)) {
                return back()->with('error', 'niveau introuvable !!');
            }

            $result = $this->levelService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Le niveau est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification niveau !!!');
            }
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
