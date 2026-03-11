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
    public function __construct(
        SectorEntityService $sectorEntityService,
        ServiceEntityService $serviceEntityService,
        EntityService $entityService,
        SectionEntityService $sectionEntityService
    ) {
        $this->sectorEntityService = $sectorEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index()
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll($this->pages);
        $sections = $this->sectionEntityService->getAll(0);

        return view('app.unities.sectors.index', [
            'services' => $services,
            'entities' => $entities,
            'sectors' => $sectors,
            'total_service' => $services->count(),
            'total_entity' => $entities->count(),
            'total_section' => $sections->count()
        ]);
    }

    public function create(Request $request)
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);

        $service_id = null;
        if ($request->has('srv')) {
            $service_id = $request->query('srv');
            $entities = $this->entityService->getAllEntityByService($service_id);
        }

        return view('app.unities.sectors.insert', [
            'services' => $services,
            'entities' => $entities,
            'service_id' => $service_id
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->sectorEntityService->create($data)) {
            return redirect()->route('sectors.index')->with('success', 'Secteur est bien enregistré !!');
        }

        return back()->with('error', 'Erreur insertion secteur');
    }

    public function edit(Request $request, $id)
    {
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

        return view('app.unities.sectors.insert', [
            'sector' => $sector,
            'services' => $services,
            'entities' => $entities,
            'service_id' => $service_id
        ]);
    }

    public function update(Request $request, $id)
    {
        $sector = $this->sectorEntityService->getOneById($id);

        if (is_null($sector)) {
            return back()->with('error', 'Secteur introuvable !!');
        }

        $data = $request->validate($this->rules);

        if ($this->sectorEntityService->update($id, $data)) {
            return redirect()->route('sectors.index')->with('success', 'Secteur est bien modifié !!');
        }

        return back()->with('error', 'Erreur modification secteur');
    }

    public function delete($id)
    {
        $sector = $this->sectorEntityService->getOneById($id);

        if (is_null($sector)) {
            return back()->with('error', 'Secteur introuvable !!');
        }

        if ($this->sectorEntityService->delete($id)) {
            return redirect()->route('sectors.index')->with('success', 'Secteur est bien supprimé !!');
        }

        return back()->with('error', 'Erreur suppression secteur');
    }

    public function show($id)
    {
        $sector = $this->sectorEntityService->getOneById($id);

        if (is_null($sector)) {
            return back()->with('error', 'Secteur introuvable !!');
        }

            return view('app.unities.sectors.show', [
            'sector' => $sector,
        ]);

        return back()->with('error', 'Erreur suppression secteur');
    }
}
