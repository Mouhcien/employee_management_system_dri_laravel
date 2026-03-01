<?php

namespace App\Http\Controllers;

use App\services\DiplomaService;
use App\services\LevelService;
use App\services\TypeEntityService;

class SettingController extends Controller
{
    private TypeEntityService $typeEntityService;
    private DiplomaService $diplomaService;
    private LevelService $levelService;
    private $pages = 10;

    /**
     * @param TypeEntityService $typeEntityService
     */
    public function __construct(TypeEntityService $typeEntityService, DiplomaService $diplomaService, LevelService $levelService)
    {
        $this->typeEntityService = $typeEntityService;
        $this->diplomaService = $diplomaService;
        $this->levelService = $levelService;
    }

    public function index() {
        try {
            $types = $this->typeEntityService->getAll($this->pages);
            $diplomas = $this->diplomaService->getAll($this->pages);
            $levels = $this->levelService->getAll($this->pages);

            return view('app.settings.index', [
                'types' => $types,
                'typeObj' => null,
                'diplomas' => $diplomas,
                'diplomaObj' => null,
                'levels' => $levels,
                'levelObj' => null
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit_diploma($id) {
        try {

            $types = $this->typeEntityService->getAll($this->pages);
            $levels = $this->levelService->getAll($this->pages);
            $diplomas = $this->diplomaService->getAll($this->pages);
            $diploma = $this->diplomaService->getOneById($id);

            if (is_null($diploma)) {
                return back()->with('error', 'diplôme introuvable !!');
            }

            return view('app.settings.index',[
                'types' => $types,
                'typeObj' => null,
                'diplomas' => $diplomas,
                'diplomaObj' => $diploma,
                'levels' => $levels,
                'levelObj' => null
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
            $levels = $this->levelService->getAll($this->pages);

            if (is_null($type)) {
                return back()->with('error', 'type introuvable !!');
            }

            return view('app.settings.index',[
                'types' => $types,
                'typeObj' => $type,
                'diplomas' => $diplomas,
                'diplomaObj' => null,
                'levels' => $levels,
                'levelObj' => null
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit_level($id) {
        try {

            $types = $this->typeEntityService->getAll($this->pages);
            $levels = $this->levelService->getAll($this->pages);
            $diplomas = $this->diplomaService->getAll($this->pages);

            $level = $this->levelService->getOneById($id);

            if (is_null($level)) {
                return back()->with('error', 'niveau introuvable !!');
            }

            return view('app.settings.index',[
                'types' => $types,
                'typeObj' => null,
                'diplomas' => $diplomas,
                'diplomaObj' => null,
                'levels' => $levels,
                'levelObj' => $level
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
