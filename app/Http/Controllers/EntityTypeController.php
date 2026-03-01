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

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->typeEntityService->create($data);

            if ($result) {
                return redirect()->route('settings')->with('success', 'Le type est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion type !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $type = $this->typeEntityService->getOneById($id);

            if (is_null($type)) {
                return back()->with('error', 'Type introuvable !!');
            }

            $result = $this->typeEntityService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du type !!');

            return redirect()->route('settings.index')->with('success', 'Le type est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $type = $this->typeEntityService->getOneById($id);

            if (is_null($type)) {
                return back()->with('error', 'type introuvable !!');
            }

            $result = $this->typeEntityService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Le type est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification type !!!');
            }
        }catch (\Exception $exception) {

        }
    }
}
