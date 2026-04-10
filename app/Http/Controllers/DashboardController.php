<?php

namespace App\Http\Controllers;

use App\services\ConfigService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\LocalService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Support\Facades\Auth;

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
        $employeesByLocals = $this->employeeService->getTotalByLocal();
        //dd($employeesByLocals);

        /*
        if (Auth::user()->profile_id == 3) {
            return view('app.audit.dashboard-auditor', [

            ]);
        }

        if (Auth::user()->profile_id == 4) {
            return view('app.audit.dashboard-supervisor', [

            ]);
        }
        */
        return view('app.dashboard', [
            'totalEmployees' => $employees->count(),
            'totalLocals' => $locals->count(),
            'employeesByCategory' => $employeesByCategory,
            'totalService' => ($services->count() - 1),
            'totalEntity' => $entities->count(),
            'totalSector' => $sectors->count(),
            'totalSection' => $sections->count(),
            'employeesByLocals' => $employeesByLocals,
        ]);

    }

    public function error() {
        return view('app.errors.index')->with('error', "Accès refusé: Profil Responsable requis.");
    }
}
