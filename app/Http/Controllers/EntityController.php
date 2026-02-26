<?php

namespace App\Http\Controllers;

use App\services\EntityService;
use App\services\ServiceEntityService;
use App\services\TypeEntityService;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    private EntityService $entityService;
    private ServiceEntityService $serviceEntityService;
    private TypeEntityService $typeEntityService;
    private $pages = 10;

    /**
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService, ServiceEntityService $serviceEntityService, TypeEntityService $typeEntityService)
    {
        $this->entityService = $entityService;
        $this->serviceEntityService = $serviceEntityService;
        $this->typeEntityService = $typeEntityService;
    }

    public function index() {
        try {

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll($this->pages);
            $types = $this->typeEntityService->getAll(0);
            return view('app.unities.entities.index', [
                'services' => $services,
                'entities' => $entities,
                'types' => $types
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
