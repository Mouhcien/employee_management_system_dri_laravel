<?php

namespace App\Http\Controllers;

use App\services\TypeEntityService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private TypeEntityService $typeEntityService;
    private $pages = 10;

    /**
     * @param TypeEntityService $typeEntityService
     */
    public function __construct(TypeEntityService $typeEntityService)
    {
        $this->typeEntityService = $typeEntityService;
    }

    public function index() {
        try {
            $types = $this->typeEntityService->getAll($this->pages);

            return view('app.settings.index', [
                'types' => $types,
                'typeObj' => null
            ]);
        }catch (\Exception $exception) {

        }
    }

}
