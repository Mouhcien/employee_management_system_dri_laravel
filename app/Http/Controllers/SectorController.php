<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use Illuminate\Http\Request;

class SectorController extends Controller
{

    private SectorEntityService $sectorEntityService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectionEntityService $sectionEntityService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'entity_id' => 'required'
    ];

    /**
     * @param SectorEntityService $sectorEntityService
     * @param ServiceEntityService $serviceEntityService
     * @param EntityService $entityService
     */
    public function __construct(SectorEntityService $sectorEntityService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectionEntityService $sectionEntityService)
    {
        $this->sectorEntityService = $sectorEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll($this->pages);
            $sections = $this->sectionEntityService->getAll(0);

            return view('app.unities.sectors.index',[
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'total_service' => $services->count(),
                'total_entity' => $entities->count(),
                'total_section' => $sections->count()
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

            return view('app.unities.sectors.insert',[
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

            $result = $this->sectorEntityService->create($data);

            if ($result) {
                return redirect()->route('sectors.index')->with('success', 'Secteur est bien enregistré !!');
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
            $sector = $this->sectorEntityService->getOneById($id);

            if (is_null($sector)) {
                return back()->with('error', 'Secteur introuvable !!');
            }

            return view('app.unities.sectors.insert',[
                'sector' => $sector,
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

            $sector = $this->sectorEntityService->getOneById($id);

            if (is_null($sector)) {
                return back()->with('error', 'Secteur introuvable !!');
            }

            $data = $request->validate($this->rules);
            $result = $this->sectorEntityService->update($id, $data);

            if ($result) {
                return redirect()->route('sectors.index')->with('success', 'Secteur est bien modifié !!');
            }else{
                return back()->with('error', 'Erreur modification secteur');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $sector = $this->sectorEntityService->getOneById($id);

            if (is_null($sector)) {
                return back()->with('error', 'Secteur introuvable !!');
            }

            $result = $this->sectorEntityService->delete($id);

            if ($result) {
                return redirect()->route('sectors.index')->with('success', 'Secteur est bien supprimé !!');
            }else{
                return back()->with('error', 'Erreur suppression secteur');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
