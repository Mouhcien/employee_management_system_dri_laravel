<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SectionController extends Controller
{
    private SectionEntityService $sectionEntityService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private $pages = 10;

    /**
     * @param SectionEntityService $sectionEntityService
     * @param ServiceEntityService $serviceEntityService
     * @param EntityService $entityService
     */
    public function __construct(
        SectionEntityService $sectionEntityService,
        ServiceEntityService $serviceEntityService,
        EntityService $entityService,
        SectorEntityService $sectorEntityService
    ) {
        $this->sectionEntityService = $sectionEntityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
    }

    public function index()
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll($this->pages);

        return view('app.unities.sections.index', [
            'services' => $services,
            'entities' => $entities,
            'sections' => $sections,
            'total_service' => $services->count(),
            'total_entity' => $entities->count(),
            'total_sector' => $sectors->count()
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

        return view('app.unities.sections.insert', [
            'services' => $services,
            'entities' => $entities,
            'service_id' => $service_id
        ]);
    }

    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();

        if ($this->sectionEntityService->create($data)) {
            return redirect()->route('sections.index')->with('success', 'Section est bien enregistré !!');
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
        $section = $this->sectionEntityService->getOneById($id);

        if (is_null($section)) {
            return back()->with('error', 'Section introuvable !!');
        }

        return view('app.unities.sections.insert', [
            'section' => $section,
            'services' => $services,
            'entities' => $entities,
            'service_id' => $service_id
        ]);
    }

    public function update(UpdateSectionRequest $request, $id)
    {
        $section = $this->sectionEntityService->getOneById($id);

        if (is_null($section)) {
            return back()->with('error', 'Section introuvable !!');
        }

        $data = $request->validated();

        if ($this->sectionEntityService->update($id, $data)) {
            return redirect()->route('sections.index')->with('success', 'Section est bien modifié !!');
        }

        return back()->with('error', 'Erreur modification secteur');
    }

    public function delete($id)
    {
        $section = $this->sectionEntityService->getOneById($id);

        if (is_null($section)) {
            return back()->with('error', 'Section introuvable !!');
        }

        if ($this->sectionEntityService->delete($id)) {
            return redirect()->route('sections.index')->with('success', 'Section est bien supprimé !!');
        }

        return back()->with('error', 'Erreur suppression secteur');
    }

    public function show($id)
    {
        $section = $this->sectionEntityService->getOneById($id);

        if (is_null($section)) {
            return back()->with('error', 'Section introuvable !!');
        }

        return view('app.unities.sections.show', [
            'section' => $section
        ]);

        return back()->with('error', 'Erreur suppression secteur');
    }
}
