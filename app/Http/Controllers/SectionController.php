<?php

namespace App\Http\Controllers;

use App\Exports\SectionExport;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use Maatwebsite\Excel\Facades\Excel;

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

    public function index(Request $request)
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll($this->pages);

        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $sections = $this->sectionEntityService->getAllByFilter($filter, $this->pages);
        }

        $entity_id = null;
        if ($request->has('ent')) {
            $entity_id = $request->query('ent');
            $sections = $this->sectionEntityService->getAllByEntity($entity_id, $this->pages);
        }

        $service_id = null;
        if ($request->has('srv')) {
            $service_id = $request->query('srv');
            $sections = $this->sectionEntityService->getAllByService($service_id, $this->pages);
            $entities = $this->entityService->getAllByService($service_id, 0);
        }

        $data_filter = null;
        if ( $request->has('srv') || $request->has('ent') || $request->has('search')) {
            $data_filter['filter'] = $filter;
            if ($entity_id != "-1")
                $data_filter['entity_id'] = $entity_id;
            if ($service_id != "-1")
                $data_filter['service_id'] = $service_id;
            $sections = $this->sectionEntityService->getAllByAllFilters($data_filter, $this->pages);
        }

        return view('app.unities.sections.index', [
            'services' => $services,
            'entities' => $entities,
            'sections' => $sections,
            'total_service' => $services->count(),
            'total_entity' => $entities->count(),
            'total_sector' => $sectors->count(),
            'filter' => $filter,
            'entity_id' => $entity_id,
            'service_id' => $service_id
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

    public function download(Request $request) {
        try {

            //['#', 'Section', 'Entity', 'Service', 'Résponsable', 'Nombre effectif'];
            $data = [];

            $sections = $this->sectionEntityService->getAll(0);

            $filter = "";
            if ($request->has('search')) {
                $filter = $request->query('search');
                $sections = $this->sectionEntityService->getAllByFilter($filter, $this->pages);
            }

            $entity_id = null;
            if ($request->has('ent')) {
                $entity_id = $request->query('ent');
                $sections = $this->sectionEntityService->getAllByEntity($entity_id, $this->pages);
            }

            $service_id = null;
            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $sections = $this->sectionEntityService->getAllByService($service_id, $this->pages);
                $entities = $this->entityService->getAllByService($service_id, 0);
            }

            $data_filter = null;
            if ( $request->has('srv') || $request->has('ent') || $request->has('search')) {
                $data_filter['filter'] = $filter;
                if ($entity_id != "-1")
                    $data_filter['entity_id'] = $entity_id;
                if ($service_id != "-1")
                    $data_filter['service_id'] = $service_id;
                $sections = $this->sectionEntityService->getAllByAllFilters($data_filter, $this->pages);
            }

            $i = 1;
            foreach ($sections as $section) {

                $sectionData[0] = $i;
                $sectionData[1] = $section->title;
                $sectionData[2] = $section->entity->title;
                $sectionData[3] = $section->entity->service->title;
                if (count($section->chefs) != 0) {
                    foreach ($section->chefs as $chef) {
                        if ($chef->state)
                            $sectionData[4] = $chef->employee->lastname." ".$chef->employee->firstname;
                    }
                }else{
                    $sectionData[4] ="";
                }

                $sectionData[5] = count($section->affectations);

                $data[] = $sectionData;
                $i++;
            }

            $date = new DateTime();
            $current_date =  $date->format('d-m-Y H:i:s');
            return Excel::download(new SectionExport($data), 'list_sections_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
