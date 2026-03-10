<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;

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

    public function index()
    {
        $services = $this->serviceEntityService->getAll(0);
        $entities = $this->entityService->getAll($this->pages);
        $types = $this->typeEntityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);

        return view('app.unities.entities.index', [
            'services' => $services,
            'entities' => $entities,
            'types' => $types,
            'total_service' => $services->count(),
            'total_sector' => $sectors->count(),
            'total_section' => $sections->count()
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


}
