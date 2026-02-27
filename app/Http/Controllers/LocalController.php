<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\LocalService;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    private CityService $cityService;
    private LocalService $localService;
    private $pages = 10;

    /**
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService, LocalService $localService)
    {
        $this->cityService = $cityService;
        $this->localService = $localService;
    }

    public function index() {
        try {

            $cities = $this->cityService->getAll(0);
            $locals = $this->localService->getAll($this->pages);

            return view('app.locals.locals.index', [
                'cities' => $cities,
                'locals' => $locals
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
