<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\LocalService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    private EmployeeService $employeeService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectionEntityService $sectionEntityService;
    private SectorEntityService $sectorEntityService;
    private LocalService $localService;
    private CityService $cityService;

    /**
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectionEntityService $sectionEntityService,
                                SectorEntityService $sectorEntityService,
                                LocalService $localService,
                                CityService $cityService
    )
    {
        $this->employeeService = $employeeService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->localService = $localService;
        $this->cityService = $cityService;
    }

    /**
     * employee
     * untities : service, entity, sector, section
     * local, city
     *
     *
     */


    public function index(Request $request)
    {
        $query = $request->query('q');

        if (empty($query)) {
            return response()->json([]);
        }

        // 1. Fetch all data
        $employees = $this->employeeService->getAllByFilterValue($query, 0);
        $services  = $this->serviceEntityService->getAllByFilter($query, 0);
        $entities  = $this->entityService->getAllByFilter($query, 0);
        $sectors   = $this->sectorEntityService->getAllByFilter($query, 0);
        $sections  = $this->sectorEntityService->getAllByFilter($query, 0);
        $locals    = $this->localService->getAllByFilter($query, 0);
        $cities    = $this->cityService->getAllByFilter($query, 0);

        // 2. Initialize a main collection to hold everything
        $formattedResults = collect();

        // 2. Format Employees + Full Data
        $formattedResults = $formattedResults->concat(collect($employees)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => trim(($item->lastname ?? '') . " " . ($item->firstname ?? '')),
                'display_category' => 'Employé(e)',
                'display_info' => $item->category->title ?? 'Personnel',
                'display_icon' => 'bi-person-badge',
                'type'         => 'employee',
                'url'          => '/employees/'.$item->id
            ]);
        }));

        // Services
        $formattedResults = $formattedResults->concat(collect($services)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title ?? $item->title,
                'display_category' => 'Services',
                'display_info' => 'Service Interne',
                'display_icon' => 'bi-building',
                'type'         => 'service',
                'url'          => '/services/'.$item->id
            ]);
        }));

        // Entities
        $formattedResults = $formattedResults->concat(collect($entities)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title ?? '',
                'display_category' => 'Entités',
                'display_info' => $item->service->title ?? '',
                'display_icon' => 'bi-building',
                'type'         => 'entité',
                'url'          => '/entities/'.$item->id
            ]);
        }));

        // sectors
        $formattedResults = $formattedResults->concat(collect($sectors)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title ?? '',
                'display_category' => 'Secteurs',
                'display_info' => $item->entity->title ?? '',
                'display_icon' => 'bi-building',
                'type'         => 'secteur',
                'url'          => '/sectors/'.$item->id
            ]);
        }));

        // sections
        $formattedResults = $formattedResults->concat(collect($sections)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title ?? $item->title,
                'display_category' => 'Sections',
                'display_info' => $item->entity->title ?? '',
                'display_icon' => 'bi-building',
                'type'         => 'section',
                'url'          => '/sections/'.$item->id
            ]);
        }));

        // Cities
        $formattedResults = $formattedResults->concat(collect($cities)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title,
                'display_category' => 'Villes',
                'display_info' => $item->title ?? 'Localisation',
                'display_icon' => 'bi-geo-alt',
                'type'         => 'city',
                'url'          => '/cities/'.$item->id
            ]);
        }));

        // locals
        $formattedResults = $formattedResults->concat(collect($locals)->map(function ($item) {
            return array_merge($item->toArray(), [
                'display_name' => $item->title,
                'display_category' => 'Locaux',
                'display_info' => $item->city->title ?? 'Localisation',
                'display_icon' => 'bi-geo-alt',
                'type'         => 'local',
                'url'          => '/locals/'.$item->id
            ]);
        }));

        return response()->json($formattedResults);
    }
}
