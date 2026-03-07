<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreAffectationRequest;
use App\Http\Requests\UpdateAffectationRequest;

class AffectationController extends Controller
{
    private AffectationService $affectationService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private EmployeeService $employeeService;

    /**
     * @param AffectationService $affectationService
     */
    public function __construct(
        AffectationService $affectationService,
        ServiceEntityService $serviceEntityService,
        EntityService $entityService,
        SectorEntityService $sectorEntityService,
        SectionEntityService $sectionEntityService,
        EmployeeService $employeeService
    ) {
        $this->affectationService = $affectationService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->employeeService = $employeeService;
    }

    public function store(StoreAffectationRequest $request)
    {
        try {
            $data = $request->validated();

            $result = $this->affectationService->create($data);

            if ($result) {
                return back()->with('success', 'Affectation est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion Affectation');

        } catch (\Exception $exception) {
            Log::error('Error in AffectationController@store: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'affectation.');
        }
    }

    public function edit(Request $request, $employee_id, $affectation_id)
    {
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

        } catch (\Exception $exception) {
            Log::error('Error in AffectationController@edit: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'édition.');
        }
    }

    public function update(UpdateAffectationRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $result = $this->affectationService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Affectation est bien modifié');
            }

            return back()->with('error', 'Erreur modification Affectation');

        } catch (\Exception $exception) {
            Log::error('Error in AffectationController@update: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification.');
        }
    }
}
