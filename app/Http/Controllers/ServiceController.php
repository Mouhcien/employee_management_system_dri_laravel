<?php

namespace App\Http\Controllers;

use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private ServiceEntityService $serviceEntityService;
    private $pages = 10;

    /**
     * @param ServiceEntityService $serviceEntityService
     */
    public function __construct(ServiceEntityService $serviceEntityService)
    {
        $this->serviceEntityService = $serviceEntityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll($this->pages);

            return view('app.unities.services.index', [
                'services' => $services
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function index_json() {
        try {

            $services = $this->serviceEntityService->getAll(0);

            return response()->json($services);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
