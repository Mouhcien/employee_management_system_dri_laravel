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
    public function __construct(ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService)
    {
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index() {
        try {

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

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->serviceEntityService->create($data);

            if ($result) {
                return redirect()->route('services.index')->with('success', 'Le service est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion service !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $service = $this->serviceEntityService->getOneById($id);

            if (is_null($service)) {
                return back()->with('error', 'Service introuvable !!');
            }

            $result = $this->serviceEntityService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du service !!');

            return redirect()->route('services.index')->with('success', 'Le service est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $service = $this->serviceEntityService->getOneById($id);

            if (is_null($service)) {
                return back()->with('error', 'Service introuvable !!');
            }

            return view('app.unities.services.show', [
                'service' => $service
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $service = $this->serviceEntityService->getOneById($id);

            if (is_null($service)) {
                return back()->with('error', 'Service introuvable !!');
            }

            $result = $this->serviceEntityService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Le service est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification service !!!');
            }
        }catch (\Exception $exception) {

        }
    }

}
