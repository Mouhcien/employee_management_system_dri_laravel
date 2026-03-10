<?php

namespace App\Http\Controllers;

use App\services\TypeEntityService;
use Illuminate\Http\Request;

class EntityTypeController extends Controller
{

    private TypeEntityService $typeEntityService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param TypeEntityService $typeEntityService
     */
    public function __construct(TypeEntityService $typeEntityService)
    {
        $this->typeEntityService = $typeEntityService;
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->typeEntityService->create($data)) {
            return redirect()->route('settings')->with('success', 'Le type est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion type !!!');
    }

    public function delete($id)
    {
        $type = $this->typeEntityService->getOneById($id);

        if (is_null($type)) {
            return back()->with('error', 'Type introuvable !!');
        }

        if (is_null($this->typeEntityService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du type !!');
        }

        return redirect()->route('settings.index')->with('success', 'Le type est bien supprimé');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $type = $this->typeEntityService->getOneById($id);

        if (is_null($type)) {
            return back()->with('error', 'type introuvable !!');
        }

        if ($this->typeEntityService->update($id, $data)) {
            return back()->with('success', 'Le type est bien modifier');
        }

        return back()->with('error', 'Erreur midification type !!!');
    }
}
