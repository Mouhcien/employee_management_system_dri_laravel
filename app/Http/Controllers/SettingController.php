<?php

namespace App\Http\Controllers;

use App\services\DiplomaService;
use App\services\TypeEntityService;

class SettingController extends Controller
{
    private TypeEntityService $typeEntityService;
    private DiplomaService $diplomaService;
    private $pages = 10;

    /**
     * @param TypeEntityService $typeEntityService
     */
    public function __construct(TypeEntityService $typeEntityService, DiplomaService $diplomaService)
    {
        $this->typeEntityService = $typeEntityService;
        $this->diplomaService = $diplomaService;
    }

    public function index() {
        try {
            $types = $this->typeEntityService->getAll($this->pages);
            $diplomas = $this->diplomaService->getAll($this->pages);

            return view('app.settings.index', [
                'types' => $types,
                'typeObj' => null,
                'diplomas' => $diplomas,
                'diplomaObj' => null
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit_diploma($id) {
        try {

            $types = $this->typeEntityService->getAll($this->pages);

            $diplomas = $this->diplomaService->getAll($this->pages);
            $diploma = $this->diplomaService->getOneById($id);

            if (is_null($diploma)) {
                return back()->with('error', 'diplôme introuvable !!');
            }

            return view('app.settings.index',[
                'types' => $types,
                'typeObj' => null,
                'diplomas' => $diplomas,
                'diplomaObj' => $diploma
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit_type($id) {
        try {

            $types = $this->typeEntityService->getAll($this->pages);
            $type = $this->typeEntityService->getOneById($id);
            $diplomas = $this->diplomaService->getAll($this->pages);

            if (is_null($type)) {
                return back()->with('error', 'type introuvable !!');
            }

            return view('app.settings.index',[
                'types' => $types,
                'typeObj' => $type,
                'diplomas' => $diplomas,
                'diplomaObj' => null
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
