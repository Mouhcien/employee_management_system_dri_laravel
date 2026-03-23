<?php

namespace App\Http\Controllers;

use App\services\ConfigService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\LocalService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;

class DashboardController extends Controller
{

    private EmployeeService $employeeService;
    private LocalService $localService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private ConfigService $configService;

    /**
     * @param EmployeeService $employeeService
     * @param LocalService $localService
     */
    public function __construct(EmployeeService $employeeService,
                                LocalService $localService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService,
                                ConfigService $configService)
    {
        parent::__construct($configService);
        $this->employeeService = $employeeService;
        $this->localService = $localService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }


    public function index() {

        $employees = $this->employeeService->getAll(0);
        $locals = $this->localService->getAll(0);
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);
        $employeesByCategory = $this->employeeService->getTotalByCategory();

        return view('app.dashboard', [
            'totalEmployees' => $employees->count(),
            'totalLocals' => $locals->count(),
            'employeesByCategory' => $employeesByCategory,
            'totalService' => $services->count(),
            'totalEntity' => $entities->count(),
            'totalSector' => $sectors->count(),
            'totalSection' => $sections->count(),
        ]);
    }
}
