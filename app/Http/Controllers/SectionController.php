<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private SectionEntityService $sectionEntityService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'entity_id' => 'required'
    ];

    /**
     * @param SectionEntityService $sectionEntityService
     * @param ServiceEntityService $serviceEntityService
     * @param EntityService $entityService
     */
    public function __construct(SectionEntityService $sectionEntityService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService)
    {
        $this->sectionEntityService = $sectionEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll($this->pages);

            return view('app.unities.sections.index',[
                'services' => $services,
                'entities' => $entities,
                'sections' => $sections,
                'total_service' => $services->count(),
                'total_entity' => $entities->count(),
                'total_sector' => $sectors->count()
            ]);

        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function create(Request $request) {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);

            $service_id = null;
            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $entities = $this->entityService->getAllEntityByService($service_id);
            }

            return view('app.unities.sections.insert',[
                'services' => $services,
                'entities' => $entities,
                'service_id' => $service_id
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->sectionEntityService->create($data);

            if ($result) {
                return redirect()->route('sections.index')->with('success', 'Section est bien enregistré !!');
            }else{
                return back()->with('error', 'Erreur insertion secteur');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit(Request $request, $id) {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);

            $service_id = null;
            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $entities = $this->entityService->getAllEntityByService($service_id);
            }
            $section = $this->sectionEntityService->getOneById($id);

            if (is_null($section)) {
                return back()->with('error', 'Section introuvable !!');
            }

            return view('app.unities.sections.insert',[
                'section' => $section,
                'services' => $services,
                'entities' => $entities,
                'service_id' => $service_id
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $section = $this->sectionEntityService->getOneById($id);

            if (is_null($section)) {
                return back()->with('error', 'Section introuvable !!');
            }

            $data = $request->validate($this->rules);
            $result = $this->sectionEntityService->update($id, $data);

            if ($result) {
                return redirect()->route('sections.index')->with('success', 'Section est bien modifié !!');
            }else{
                return back()->with('error', 'Erreur modification secteur');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $section = $this->sectionEntityService->getOneById($id);

            if (is_null($section)) {
                return back()->with('error', 'Section introuvable !!');
            }

            $result = $this->sectionEntityService->delete($id);

            if ($result) {
                return redirect()->route('sections.index')->with('success', 'Section est bien supprimé !!');
            }else{
                return back()->with('error', 'Erreur suppression secteur');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
