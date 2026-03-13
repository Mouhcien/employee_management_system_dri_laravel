<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param ServiceEntityService $serviceEntityService
     */
    public function __construct(
        ServiceEntityService $serviceEntityService,
        EntityService $entityService,
        SectorEntityService $sectorEntityService,
        SectionEntityService $sectionEntityService
    ) {
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index()
    {
        $services = $this->serviceEntityService->getAll($this->pages);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);

        return view('app.unities.services.index', [
            'services' => $services,
            'total_entity' => $entities->count(),
            'total_sector' => $sectors->count(),
            'total_section' => $sections->count()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->serviceEntityService->create($data)) {
            return redirect()->route('services.index')->with('success', 'Le service est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion service !!!');
    }

    public function delete($id)
    {
        $service = $this->serviceEntityService->getOneById($id);

        if (is_null($service)) {
            return back()->with('error', 'Service introuvable !!');
        }

        if ($this->serviceEntityService->delete($id)) {
            return redirect()->route('services.index')->with('success', 'Le service est bien supprimé');
        }

        return back()->with('error', 'Erreur au suppression du service !!');
    }

    public function show($id)
    {
        $service = $this->serviceEntityService->getOneById($id);

        if (is_null($service)) {
            return back()->with('error', 'Service introuvable !!');
        }

        return view('app.unities.services.show', [
            'service' => $service
        ]);
    }

    public function update(Request $request, $id)
    {

        $data = $request->validate($this->rules);

        $service = $this->serviceEntityService->getOneById($id);

        if (is_null($service)) {
            return back()->with('error', 'Service introuvable !!');
        }

        if ($this->serviceEntityService->update($id, $data)) {
            return back()->with('success', 'Le service est bien modifier');
        }

        return back()->with('error', 'Erreur midification service !!!');
    }

}
