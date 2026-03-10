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

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->levelService->create($data)) {
            return redirect()->route('settings')->with('success', 'Le niveau est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion niveau !!!');
    }

    public function delete($id)
    {
        $level = $this->levelService->getOneById($id);

        if (is_null($level)) {
            return back()->with('error', 'Niveau introuvable !!');
        }

        if (is_null($this->levelService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du niveau !!');
        }

        return redirect()->route('settings')->with('success', 'Le niveau est bien supprimé');
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $level = $this->levelService->getOneById($id);

        if (is_null($level)) {
            return back()->with('error', 'niveau introuvable !!');
        }

        if ($this->levelService->update($id, $data)) {
            return back()->with('success', 'Le niveau est bien modifier');
        }

        return back()->with('error', 'Erreur midification niveau !!!');
    }
}
