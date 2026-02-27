<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\LocalService;
use Illuminate\Http\Request;

class CityController extends Controller
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

            $cities = $this->cityService->getAll($this->pages);
            $locals = $this->localService->getAll(0);

            return view('app.locals.cities.index', [
                'cities' => $cities,
                'locals' => $locals
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
