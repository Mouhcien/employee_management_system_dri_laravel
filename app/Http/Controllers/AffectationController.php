<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    private AffectationService $affectationService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private EmployeeService $employeeService;

    private $rules = [
        'employee_id' => 'required',
        'service_id' => 'required',
        'entity_id' => 'required',
        'sector_id' => 'required',
        'section_id' => 'required',
        'affectation_date' => 'required',
    ];

    /**
     * @param AffectationService $affectationService
     */
    public function __construct(AffectationService $affectationService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService,
                                EmployeeService $employeeService)
    {
        $this->affectationService = $affectationService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->employeeService = $employeeService;
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->affectationService->create($data);

            if ($result) {
                return back()->with('success', 'Affectation est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion Affectation');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function edit(Request $request, $employee_id, $affectation_id){
        try {
            $employee = $this->employeeService->getOneById($employee_id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $affectation = $this->affectationService->getOneById($affectation_id);
            if (is_null($affectation)) {
                return back()->with('error', 'Affectation introuvable');
            }

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            $service_id = null;
            $entity_id = null;

            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $entities = $this->entityService->getAllByService($service_id, 0);
            }

            if ($request->has('ent')) {
                $entity_id = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($entity_id, 0);
                $sections = $this->sectionEntityService->getAllByEntity($entity_id, 0);
            }

            return view('app.employees.unities', [
                'employee' => $employee,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections,
                'affectationObj' => $affectation,
                'service_id' => $service_id,
                'entity_id' => $entity_id
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->affectationService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Affectation est bien modifié');
            }

            return back()->with('error', 'Erreur modification Affectation');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
