<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private SectionEntityService $sectionEntityService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private $pages = 10;

    /**
     * @param SectionEntityService $sectionEntityService
     * @param ServiceEntityService $serviceEntityService
     * @param EntityService $entityService
     */
    public function __construct(SectionEntityService $sectionEntityService, ServiceEntityService $serviceEntityService, EntityService $entityService)
    {
        $this->sectionEntityService = $sectionEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sections = $this->sectionEntityService->getAll($this->pages);

            return view('app.unities.sections.index',[
                'services' => $services,
                'entities' => $entities,
                'sections' => $sections
            ]);

        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }
}
