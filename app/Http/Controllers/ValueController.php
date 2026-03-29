<?php

namespace App\Http\Controllers;

use App\services\ColumnService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\PeriodService;
use App\services\RelationService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TableService;
use App\services\ValueService;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    private ValueService $valueService;
    private TableService $tableService;
    private RelationService $relationService;
    private ColumnService $columnService;
    private EmployeeService $employeeService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectorEntityService $sectorEntityService;
    private SectionEntityService $sectionEntityService;
    private PeriodService $periodService;

    /**
     * @param ValueService $valueService
     */
    public function __construct(ValueService $valueService,
                                TableService $tableService,
                                ColumnService $columnService,
                                RelationService $relationService,
                                EmployeeService $employeeService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService,
                                PeriodService $periodService
    )
    {
        $this->valueService = $valueService;
        $this->tableService = $tableService;
        $this->columnService = $columnService;
        $this->relationService = $relationService;
        $this->employeeService = $employeeService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->periodService = $periodService;
    }

    public function index(Request $request) {
        try {

            $tables = $this->tableService->getAll(0);
            $periods = $this->periodService->getAll(0);
            $employees = $this->employeeService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            $selected_table = null;
            $tableObj = null;
            if ($request->has('tbl')) {
                $selected_table = $request->query('tbl');
                $tableObj = $this->tableService->getOneById($selected_table);
            }

            $selected_service = null;
            if ($request->has('srv')) {
                $selected_service = $request->query('srv');
                $entities = $this->entityService->getAllByService($selected_service, 0);
                $employees = $this->employeeService->getAllByService($selected_service, 0);
            }

            $selected_entity = null;
            if ($request->has('ent')) {
                $selected_entity = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($selected_entity, 0);
                $sections = $this->sectionEntityService->getAllByEntity($selected_entity, 0);
                $employees = $this->employeeService->getAllByEntity($selected_entity, 0);
            }

            $selected_sector = null;
            if ($request->has('sectr')) {
                $selected_sector = $request->query('sectr');
                $employees = $this->employeeService->getAllBySector($selected_sector, 0);
            }

            $selected_section = null;
            if ($request->has('sect')) {
                $selected_section = $request->query('sect');
                $employees = $this->employeeService->getAllBySection($selected_section, 0);
            }

            return view('app.audit.values.index', [
                'tables' => $tables,
                'periods' => $periods,
                'tableObj' => $tableObj,
                'selected_table' => $selected_table,
                'employees' => $employees,
                'selected_service' => $selected_service,
                'selected_entity' => $selected_entity,
                'selected_sector' => $selected_sector,
                'selected_section' => $selected_section,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections
            ]);


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function consult(Request $request) {
        try {

            $tables = $this->tableService->getAll(0);
            $periods = $this->periodService->getAll(0);
            $employees = $this->employeeService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);
            $values = $this->valueService->getAll(0);

            $selected_table = null;
            $tableObj = null;
            if ($request->has('tbl')) {
                $selected_table = $request->query('tbl');
                $tableObj = $this->tableService->getOneById($selected_table);
                $values = $this->valueService->getAllByTable($selected_table, 0);
            }

            $selected_period = null;
            $periodObj = null;
            if ($request->has('perd')) {
                $selected_period = $request->query('perd');
                $periodObj = $this->periodService->getOneById($selected_period);
                $values = $this->valueService->getAllByPeriod($selected_period, 0);
            }

            $selected_service = null;
            if ($request->has('srv')) {
                $selected_service = $request->query('srv');
                $entities = $this->entityService->getAllByService($selected_service, 0);
                $employees = $this->employeeService->getAllByService($selected_service, 0);
            }

            $selected_entity = null;
            if ($request->has('ent')) {
                $selected_entity = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($selected_entity, 0);
                $sections = $this->sectionEntityService->getAllByEntity($selected_entity, 0);
                $employees = $this->employeeService->getAllByEntity($selected_entity, 0);
            }

            $selected_sector = null;
            if ($request->has('sectr')) {
                $selected_sector = $request->query('sectr');
                $employees = $this->employeeService->getAllBySector($selected_sector, 0);
            }

            $selected_section = null;
            if ($request->has('sect')) {
                $selected_section = $request->query('sect');
                $employees = $this->employeeService->getAllBySection($selected_section, 0);
            }

            return view('app.audit.values.consult', [
                'tables' => $tables,
                'periods' => $periods,
                'tableObj' => $tableObj,
                'selected_table' => $selected_table,
                'employees' => $employees,
                'selected_service' => $selected_service,
                'selected_entity' => $selected_entity,
                'selected_sector' => $selected_sector,
                'selected_section' => $selected_section,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections,
                'values' => $values,
                'selected_period' => $selected_period,
                'periodObj' => $periodObj
            ]);


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data['period_id'] = $request->period_id;
            $data['employee_id'] = $request->employee_id;

            for ($i=0; $i<count($request->relations); $i++) {
                $data['relation_id'] = $request->relations[$i];
                $data['value'] = $request->values[$i];

                $this->valueService->create($data);
            }

            return redirect()->route('audit.values.index')->with('success', "Sauvgrade est bien faite !!!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
