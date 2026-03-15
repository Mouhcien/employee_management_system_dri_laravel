<?php

namespace App\Http\Controllers;

use App\Exports\serviceExport;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function index(Request $request)
    {
        $services = $this->serviceEntityService->getAll($this->pages);
        $entities = $this->entityService->getAll(0);
        $sectors = $this->sectorEntityService->getAll(0);
        $sections = $this->sectionEntityService->getAll(0);

        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $services = $this->serviceEntityService->getAllByFilter($filter, $this->pages);
        }

        return view('app.unities.services.index', [
            'services' => $services,
            'total_entity' => $entities->count(),
            'total_sector' => $sectors->count(),
            'total_section' => $sections->count(),
            'filter' => $filter
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

    public function download() {
        try {
            //['#', 'Service', 'Résponsable', 'Nombre effectif'];
            $data = [];
            $services = $this->serviceEntityService->getAll(0);

            $i = 1;
            foreach ($services as $service) {

                $serviceData[0] = $i;
                $serviceData[1] = $service->title;
                if (count($service->chefs) != 0) {
                    foreach ($service->chefs as $chef) {
                        if ($chef->state)
                            $serviceData[2] = $chef->employee->lastname." ".$chef->employee->firstname;
                    }
                }else{
                    $serviceData[2] ="";
                }

                $serviceData[3] = count($service->affectations);

                $data[] = $serviceData;
                $i++;
            }

            $date = new DateTime();
            $current_date =  $date->format('Y-m-d H:i:s');
            return Excel::download(new ServiceExport($data), 'list_services_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

}
