<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class SectorController extends Controller
{

    private SectorEntityService $sectorEntityService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private $pages = 10;

    /**
     * @param SectorEntityService $sectorEntityService
     * @param ServiceEntityService $serviceEntityService
     * @param EntityService $entityService
     */
    public function __construct(SectorEntityService $sectorEntityService, ServiceEntityService $serviceEntityService, EntityService $entityService)
    {
        $this->sectorEntityService = $sectorEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll($this->pages);

            return view('app.unities.sectors.index',[
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors
            ]);

        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }


}
