<?php

namespace App\Http\Controllers;

use App\Exports\EntityExport;
use App\Exports\SectorExport;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function index(Request $request)
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll($this->pages);

        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $sectors = $this->sectorEntityService->getAllByFilter($filter, $this->pages);
        }

        $entity_id = null;
        if ($request->has('ent')) {
            $entity_id = $request->query('ent');
            $sectors = $this->sectorEntityService->getAllByEntity($entity_id, $this->pages);
        }

        $service_id = null;
        if ($request->has('srv')) {
            $service_id = $request->query('srv');
            $sectors = $this->sectorEntityService->getAllByService($service_id, $this->pages);
            $entities = $this->entityService->getAllByService($service_id, 0);
        }

        $data_filter = null;
        if ( $request->has('srv') || $request->has('ent') || $request->has('search')) {
            $data_filter['filter'] = $filter;
            if ($entity_id != "-1")
                $data_filter['entity_id'] = $entity_id;
            if ($service_id != "-1")
                $data_filter['service_id'] = $service_id;
            $sectors = $this->sectorEntityService->getAllByAllFilters($data_filter, $this->pages);
        }

        return view('app.unities.sectors.index', [
            'services' => $services,
            'entities' => $entities,
            'sectors' => $sectors,
            'total_service' => $services->count(),
            'total_entity' => $entities->count(),
            'total_section' => $sections->count(),
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

    public function download(Request $request) {
        try {

            //['#', 'Secteur', 'Entity', 'Service', 'Résponsable', 'Nombre effectif'];
            $data = [];

            $sectors = $this->sectorEntityService->getAll(0);

            $filter = "";
            if ($request->has('search')) {
                $filter = $request->query('search');
                $sectors = $this->sectorEntityService->getAllByFilter($filter, $this->pages);
            }

            $entity_id = null;
            if ($request->has('ent')) {
                $entity_id = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($entity_id, $this->pages);
            }

            $service_id = null;
            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $sectors = $this->sectorEntityService->getAllByService($service_id, $this->pages);
            }

            $data_filter = null;
            if ( $request->has('srv') || $request->has('ent') || $request->has('search')) {
                $data_filter['filter'] = $filter;
                if ($entity_id != "-1")
                    $data_filter['entity_id'] = $entity_id;
                if ($service_id != "-1")
                    $data_filter['service_id'] = $service_id;
                $sectors = $this->sectorEntityService->getAllByAllFilters($data_filter, $this->pages);
            }

            $i = 1;
            foreach ($sectors as $sector) {

                $sectorData[0] = $i;
                $sectorData[1] = $sector->title;
                $sectorData[2] = $sector->entity->title;
                $sectorData[3] = $sector->entity->service->title;
                if (count($sector->chefs) != 0) {
                    foreach ($sector->chefs as $chef) {
                        if ($chef->state)
                            $sectorData[4] = $chef->employee->lastname." ".$chef->employee->firstname;
                    }
                }else{
                    $sectorData[4] ="";
                }

                $sectorData[5] = count($sector->affectations);

                $data[] = $sectorData;
                $i++;
            }

            $date = new DateTime();
            $current_date =  $date->format('d-m-Y H:i:s');
            return Excel::download(new SectorExport($data), 'list_secteurs_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
