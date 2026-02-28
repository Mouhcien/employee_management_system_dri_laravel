<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    private EntityService $entityService;
    private ServiceEntityService $serviceEntityService;
    private TypeEntityService $typeEntityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'type_id' => 'required',
        'service_id' => 'required'
    ];

    /**
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService,
                                ServiceEntityService $serviceEntityService,
                                TypeEntityService $typeEntityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService)
    {
        $this->entityService = $entityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->typeEntityService = $typeEntityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index() {
        try {

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

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function create() {
        try {

            $types = $this->typeEntityService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);

            return view('app.unities.entities.insert',[
                'types' => $types,
                'services' => $services,
            ]);
        }catch (\Exception $exception) {

        }
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->entityService->create($data);

            if ($result) {
                return redirect()->route('entities.index')->with('success', "L'entité est bien enrgistré !!!");
            }else {
                return back()->with('error', 'Erreur insrttion des entité !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit($id) {
        try {

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
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $entity = $this->entityService->getOneById($id);

            if (is_null($entity)) {
                return back()->with('error', 'Entité introuvable !!');
            }

            return view('app.unities.entities.show', [
                'entity' => $entity
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $entity = $this->entityService->getOneById($id);

            if (is_null($entity)) {
                return back()->with('error', 'Entité introuvable !!');
            }

            $data = $request->validate($this->rules);

            $result = $this->entityService->update($id, $data);

            if ($result) {
                return redirect()->route('entities.index')->with('success', "L'entité est bien midifié !!!");
            }else {
                return back()->with('error', 'Erreur modification entité !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $entity = $this->entityService->getOneById($id);

            if (is_null($entity)) {
                return back()->with('error', 'Entité introuvable !!');
            }

            $result = $this->entityService->delete($id);

            if ($result) {
                return redirect()->route('entities.index')->with('success', "L'entité est bien supprimé !!!");
            }else {
                return back()->with('error', 'Erreur suppression entité !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }


}
