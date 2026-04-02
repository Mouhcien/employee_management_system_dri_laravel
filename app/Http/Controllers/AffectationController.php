<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAffectationRequest;
use App\Http\Requests\UpdateAffectationRequest;
use Maatwebsite\Excel\Facades\Excel;

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
        $data = $request->validated();
        $old_affectation = $request->input('old_affectation');

        if (!is_null($old_affectation)) {
            $affectation = $this->affectationService->getOneById($old_affectation);
            if (is_null($affectation))
                return back()->with('error', "L'encien affectation est introuvable !!");

            $this->affectationService->changeState($old_affectation, false);
        }

        if ($this->affectationService->create($data)) {
            return back()->with('success', 'Affectation est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion Affectation');
    }

    public function edit(Request $request, $employee_id, $affectation_id)
    {
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
    }

    public function update(UpdateAffectationRequest $request, $id)
    {
        $data = $request->validated();

        if ($this->affectationService->update($id, $data)) {
            return back()->with('success', 'Affectation est bien modifié');
        }

        return back()->with('error', 'Erreur modification Affectation');
    }

    public function import_section(Request $request) {
        try {
            $section_id = $request->input('section_id');

            if ($request->hasFile('file')) {

                $section = $this->sectionEntityService->getOneById($section_id);

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                $count = 0;
                foreach ($rows[0] as $rr) {
                    $data['service_id'] = $section->entity->service_id;
                    $data['entity_id'] = $section->entity_id;
                    $data['section_id'] = $section->id;
                    $data['sector_id'] = null;
                    $data['affectation_date'] = null;

                    $employee = $this->employeeService->getOneByPPR($rr[0]);
                    $data['employee_id'] = $employee->id;

                    $this->affectationService->create($data);
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('sections.show', $section_id)->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('sections.show', $section_id)->with('error', "Employé sont affecté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('sections.show', $section_id)->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function import_sector(Request $request) {
        try {
            $sector_id = $request->input('sector_id');

            if ($request->hasFile('file')) {

                $sector = $this->sectorEntityService->getOneById($sector_id);

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                $count = 0;
                foreach ($rows[0] as $rr) {
                    $data['service_id'] = $sector->entity->service_id;
                    $data['entity_id'] = $sector->entity_id;
                    $data['section_id'] = null;
                    $data['sector_id'] = $sector->id;
                    $data['affectation_date'] = null;

                    $employee = $this->employeeService->getOneByPPR($rr[0]);
                    $data['employee_id'] = $employee->id;

                    $this->affectationService->create($data);
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('sectors.show', $sector_id)->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('sectors.show', $sector_id)->with('error', "Employé sont affecté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('sectors.show', $sector_id)->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function import_entity(Request $request) {
        try {
            $entity_id = $request->input('entity_id');

            if ($request->hasFile('file')) {

                $entity = $this->entityService->getOneById($entity_id);

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                $count = 0;
                foreach ($rows[0] as $rr) {
                    $data['service_id'] = $entity->service_id;
                    $data['entity_id'] = $entity_id;
                    $data['section_id'] = null;
                    $data['sector_id'] = null;
                    $data['affectation_date'] = null;

                    $employee = $this->employeeService->getOneByPPR($rr[0]);
                    $data['employee_id'] = $employee->id;

                    $this->affectationService->create($data);
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('entities.show', $entity_id)->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('entities.show', $entity_id)->with('error', "Employé sont affecté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('entities.show', $entity_id)->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function import_service(Request $request) {
        try {

            $service_id = $request->input('service_id');

            if ($request->hasFile('file')) {

                $service = $this->serviceEntityService->getOneById($service_id);

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                $count = 0;
                foreach ($rows[0] as $rr) {
                    $data['service_id'] = $service->id;
                    $data['entity_id'] = null;
                    $data['section_id'] = null;
                    $data['sector_id'] = null;
                    $data['affectation_date'] = null;

                    $employee = $this->employeeService->getOneByPPR($rr[0]);
                    $data['employee_id'] = $employee->id;

                    $this->affectationService->create($data);
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('services.show', $service_id)->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('services.show', $service_id)->with('error', "Employé sont affecté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('services.show', $service_id)->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
