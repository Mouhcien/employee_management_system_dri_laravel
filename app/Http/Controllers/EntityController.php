<?php

namespace App\Http\Controllers;

use App\Exports\EntityExport;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use Maatwebsite\Excel\Facades\Excel;

class EntityController extends Controller
{
    private EntityService $entityService;
    private ServiceEntityService $serviceEntityService;
    private TypeEntityService $typeEntityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private $pages = 10;

    /**
     * @param EntityService $entityService
     */
    public function __construct(
        EntityService $entityService,
        ServiceEntityService $serviceEntityService,
        TypeEntityService $typeEntityService,
        SectorEntityService $sectorEntityService,
        SectionEntityService $sectionEntityService
    ) {
        $this->entityService = $entityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->typeEntityService = $typeEntityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index(Request $request)
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll($this->pages);
        $types = $this->typeEntityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);

        $data = null;
        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $entities = $this->entityService->getAllByFilter($filter, $this->pages);
        }

        $type_id = null;
        if ($request->has('cat')) {
            $type_id = $request->query('cat');
            $entities = $this->entityService->getAllByType($type_id, $this->pages);
        }

        $service_id = null;
        if ($request->has('srv')) {
            $service_id = $request->query('srv');
            $entities = $this->entityService->getAllByService($service_id, $this->pages);
        }

        if ( $request->has('srv') || $request->has('cat') || $request->has('search')) {
            $data['filter'] = $filter;
            $data['type_id'] = $type_id;
            $data['service_id'] = $service_id;
            $entities = $this->entityService->getAllByAllFilters($data, $this->pages);
        }

        return view('app.unities.entities.index', [
            'services' => $services,
            'entities' => $entities,
            'types' => $types,
            'total_service' => $services->count(),
            'total_sector' => $sectors->count(),
            'total_section' => $sections->count(),
            'filter' => $filter,
            'service_id' => $service_id,
            'type_id' => $type_id
        ]);
    }

    public function create()
    {
        $types = $this->typeEntityService->getAll(0);
        $services = $this->serviceEntityService->getAll(0);

        return view('app.unities.entities.insert', [
            'types' => $types,
            'services' => $services,
        ]);
    }

    public function store(StoreEntityRequest $request)
    {
        $data = $request->validated();

        if ($this->entityService->create($data)) {
            return redirect()->route('entities.index')->with('success', "L'entité est bien enrgistré !!!");
        }

        return back()->with('error', 'Erreur insertion des entité !!!');
    }

    public function edit($id)
    {
        $entity = $this->entityService->getOneById($id);
        $types = $this->typeEntityService->getAll(0);
        $services = $this->serviceEntityService->getAll(0);

        if (is_null($entity)) {
            return back()->with('error', 'Entité introuvable !!');
        }

        return view('app.unities.entities.insert', [
            'entity' => $entity,
            'services' => $services,
            'types' => $types
        ]);
    }

    public function show($id)
    {
        $entity = $this->entityService->getOneById($id);

        if (is_null($entity)) {
            return back()->with('error', 'Entité introuvable !!');
        }

        return view('app.unities.entities.show', [
            'entity' => $entity
        ]);
    }

    public function update(UpdateEntityRequest $request, $id)
    {
        $entity = $this->entityService->getOneById($id);

        if (is_null($entity)) {
            return back()->with('error', 'Entité introuvable !!');
        }

        $data = $request->validated();

        if ($this->entityService->update($id, $data)) {
            return redirect()->route('entities.index')->with('success', "L'entité est bien modifiée !!!");
        }

        return back()->with('error', 'Erreur modification entité !!!');
    }

    public function delete($id)
    {
        $entity = $this->entityService->getOneById($id);

        if (is_null($entity)) {
            return back()->with('error', 'Entité introuvable !!');
        }

        if ($this->entityService->delete($id)) {
            return redirect()->route('entities.index')->with('success', "L'entité est bien supprimé !!!");
        }

        return back()->with('error', 'Erreur suppression entité !!!');
    }


    public function download(Request $request) {
        try {

            //['#', 'Type', 'Entity', 'Service', 'Résponsable', 'Nombre effectif'];
            $data = [];

            $entities = $this->entityService->getAll(0);

            $filter = "";
            if ($request->has('search')) {
                $filter = $request->query('search');
                $entities = $this->entityService->getAllByFilter($filter, $this->pages);
            }

            $type_id = null;
            if ($request->has('cat')) {
                $type_id = $request->query('cat');
                $entities = $this->entityService->getAllByType($type_id, $this->pages);
            }

            $service_id = null;
            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $entities = $this->entityService->getAllByService($service_id, $this->pages);
            }

            $data_filter = null;
            if ( $request->has('srv') || $request->has('cat') || $request->has('search')) {
                $data_filter['filter'] = $filter;
                $data_filter['type_id'] = $type_id;
                $data_filter['service_id'] = $service_id;
                $entities = $this->entityService->getAllByAllFilters($data_filter, $this->pages);
            }

            $i = 1;
            foreach ($entities as $entity) {

                $entityData[0] = $i;
                $entityData[1] = $entity->type->title;
                $entityData[2] = $entity->title;
                $entityData[3] = $entity->service->title;
                if (count($entity->chefs) != 0) {
                    foreach ($entity->chefs as $chef) {
                        if ($chef->state)
                            $entityData[4] = $chef->employee->lastname." ".$chef->employee->firstname;
                    }
                }else{
                    $entityData[4] ="";
                }

                $entityData[5] = count($entity->affectations);

                $data[] = $entityData;
                $i++;
            }

            $date = new DateTime();
            $current_date =  $date->format('d-m-Y H:i:s');
            return Excel::download(new EntityExport($data), 'list_entités_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


}
