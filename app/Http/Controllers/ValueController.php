<?php

namespace App\Http\Controllers;

use App\Exports\ChefExport;
use App\Exports\ModelPerformance;
use App\Models\Employee;
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
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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

    private $pages = 10;

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

            $selected_period = null;
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
                'sections' => $sections,
                'selected_period' => $selected_period,
                'values' => null
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
            //$values = $this->valueService->getAll($this->pages);

            $values = [];

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

            $selected_employee = null;
            if ($request->has('emp')) {
                $selected_employee = $request->query('emp');
                $values = $this->valueService->getAllByEmployee($selected_employee, 0);
            }

            if ($request->has('emp') || $request->has('perd') || $request->has('tbl')) {
                $filter['table_id'] = $selected_table;
                $filter['period_id'] = $selected_period;
                $filter['employee_id'] = $selected_employee;

                $values = $this->valueService->getAllByFilters($filter, 0);
            }

            //dd($values);

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
                'periodObj' => $periodObj,
                'selected_employee' => $selected_employee
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

    public function import(Request $request) {
        try {
            //dd($request);

            $data['period_id'] = $request->period_id;
            $data['table_id'] = $request->table_id;

            $period = $this->periodService->getOneById($request->period_id);
            if (is_null($period))
                return back()->with('error', 'Période introuvable !!!');

            $table = $this->tableService->getOneById($request->table_id);
            if (is_null($table))
                return back()->with('error', 'Le tableau de suivi est introuvable !!!');

            //get table columns

            $columns = $this->columnService->getAllColumnsByTable($table->id);

            if ($request->hasFile('file')) {

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                //get the headers
                $headers = null;
                foreach ($rows[0] as $rr) {
                    $headers = $rr;
                    break;
                }

                $count = 0; //count the header
                foreach ($rows[0] as $rr) {
                    if ($count > 0) {
                        foreach ($columns as $column) {
                            $data['relation_id'] = $column->relations[0]->id;
                            $j=0;
                            foreach ($headers as $header) {
                                if ($header == 'PPR')
                                    $data['employee_id'] = $this->employeeService->getOneByPPR($rr[$j])->id;

                                if ($column->title == $header)
                                    $data['value'] = $rr[$j];
                                $j++;
                            }
                            $this->valueService->create($data);
                        }
                    }
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('audit.values.index')->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('audit.values.index')->with('error', "Erreur lors d'imortation !!! " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('audit.values.index')->with('error', "Merci de spécifier le fichier excel !!!");
            }



            return redirect()->route('audit.values.index')->with('success', "Sauvgrade est bien faite !!!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit(Request $request, $id, $attr) {
        try {

            $relationObj = $this->relationService->getOneById($id);
            if(is_null($relationObj))
                return back()->with('error', "Elements introuvable !!");

            $tables = $this->tableService->getAll(0);
            $periods = $this->periodService->getAll(0);
            $employees = $this->employeeService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            $selected_period = $relationObj->period_id;

            $selected_table = $relationObj->table_id;
            $tableObj = $relationObj->table;
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

            $values_id = explode('-', $attr);
            $values = $this->valueService->getAllByIds($values_id);

            return view('app.audit.values.index', [
                'tables' => $tables,
                'periods' => $periods,
                'selected_period' => $selected_period,
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
                'relationObj' => $relationObj,
                'values' => $values
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request) {
        try {

            $data['period_id'] = $request->period_id;
            $data['employee_id'] = $request->employee_id;

            $ids = $request->ids;
            $j = 0;
            for ($i=0; $i<count($request->relations); $i++) {
                $data['relation_id'] = $request->relations[$i];
                $data['value'] = $request->values[$i];

                if (is_null($ids[$j])) {
                    $this->valueService->create($data);
                }else{
                    $this->valueService->update($ids[$j], $data);
                }
                $j++;
            }

            return redirect()->route('audit.values.consult')->with('success', "Sauvgrade est bien faite !!!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($attr) {
        try {
            $values_id = explode('-', $attr);
            $values = $this->valueService->getAllByIds($values_id);
            $no_existed = 0;
            foreach ($values as $value) {
                $valueObject = $this->valueService->getOneById($value->id);
                if (is_null($valueObject))
                    $no_existed++;
            }

            if ($no_existed == 0) {
                foreach ($values as $value) {
                    $this->valueService->delete($value->id);
                }
            }else{
                return back()->with('error', 'Elements introuvable');
            }

            return redirect()->route('audit.values.consult')->with('success', "Suppression est bien faite !!!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function select(Request $request) {
        try {

            $periods = $this->periodService->getAll(0);
            $employees = $this->employeeService->getAll($this->pages);
            $employees_all = $this->employeeService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            $selected_service = null;
            if ($request->has('srv')) {
                $selected_service = $request->query('srv');
                $entities = $this->entityService->getAllByService($selected_service, 0);
                $employees = $this->employeeService->getAllByService($selected_service, $this->pages);
                $employees_all = $this->employeeService->getAllByService($selected_service, 0);
            }

            $selected_entity = null;
            if ($request->has('ent')) {
                $selected_entity = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($selected_entity, 0);
                $sections = $this->sectionEntityService->getAllByEntity($selected_entity, 0);
                $employees = $this->employeeService->getAllByEntity($selected_entity, $this->pages);
                $employees_all = $this->employeeService->getAllByEntity($selected_entity, 0);
            }

            $selected_sector = null;
            if ($request->has('sectr')) {
                $selected_sector = $request->query('sectr');
                $employees = $this->employeeService->getAllBySector($selected_sector, $this->pages);
                $employees_all = $this->employeeService->getAllBySector($selected_sector, 0);
            }

            $selected_section = null;
            if ($request->has('sect')) {
                $selected_section = $request->query('sect');
                $employees = $this->employeeService->getAllBySection($selected_section, $this->pages);
                $employees_all = $this->employeeService->getAllBySection($selected_section, 0);
            }


            return view('app.audit.values.select', [
                'periods' => $periods,
                'employees' => $employees,
                'employees_all' => $employees_all,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections,
                'selected_service' => $selected_service,
                'selected_entity' => $selected_entity,
                'selected_sector' => $selected_sector,
                'selected_section' => $selected_section,
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function view ($emp){
        try {

            $employee = $this->employeeService->getOneById($emp);
            if (is_null($employee)) {
                return back()->with('error', "Employée introuvable !!");
            }

            $values = $this->valueService->getAllByEmployee($emp, 0);

            return view('app.audit.values.view', [
                'employee' => $employee,
                'values' => $values,
                'groupedValues' => $values->groupBy('employee_id'),
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function view_entity ($entityName, $id){
        try {

            $employees = [];
            $service = null;
            $entity = null;
            $sector = null;
            $section = null;
            $employee = null;
            $values = [];
            switch (strtolower($entityName)) {
                case 'service':
                    $service = $this->serviceEntityService->getOneById($id);
                    if (is_null($service)) {
                        return back()->with('error', "Service introuvable !!");
                    }
                    $employees = $this->employeeService->getAllByService($id);
                    $employee = $service->chefs->where('state', "=", 1)->first()->employee;
                    $values = $this->valueService->getAllByService($id);
                    break;

                case 'entité':
                    $entity = $this->entityService->getOneById($id);
                    if (is_null($entity)) {
                        return back()->with('error', "Entité introuvable !!");
                    }
                    $employees = $this->employeeService->getAllByEntity($id);
                    $employee = $entity->chefs->where('state', "=", 1)->first()->employee;
                    $values = $this->valueService->getAllByEntity($id);
                    break;

                case 'secteur':
                    $sector = $this->sectorEntityService->getOneById($id);
                    if (is_null($sector)) {
                        return back()->with('error', "Secteur introuvable !!");
                    }
                    $employees = $this->employeeService->getAllByService($id);
                    $employee = $sector->chefs->where('state', "=", 1)->first()->employee;
                    $values = $this->valueService->getAllBySector($id);
                    break;

                case 'section':
                    $section = $this->sectionEntityService->getOneById($id);
                    if (is_null($section)) {
                        return back()->with('error', "Section introuvable !!");
                    }
                    $employees = $this->employeeService->getAllBySection($id);
                    $employee = $section->chefs->where('state', "=", 1)->first()->employee;
                    $values = $this->valueService->getAllBySection($id);
                    break;
            }

            //dd($values);

            return view('app.audit.values.view-entity', [
                'employees' => $employees,
                'service' => $service,
                'entity' => $entity,
                'sector' => $sector,
                'section' => $section,
                'employee' => $employee,
                'values' => $values
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function download_model(Request $request, $tbl, $srv=null, $ent=null, $sectr=null, $sect=null) {
        try {

            $table = $this->tableService->getOneById($tbl);
            if (is_null($table))
                return back()->with('error', "Tableau de suivi introuvable !!!");

            $headings = [];

            $headings[0] = "Tableau de suivi";
            $headings[1] = "PPR";
            $headings[2] = "Agent";

            $employees = null;
            if (!is_null($srv) && $srv != 0) {
                $selected_service = $srv;
                $employees = $this->employeeService->getAllByService($selected_service, 0);
                $headings[3] = "Service";
            }

            if (!is_null($ent) && $ent != 0) {
                $selected_entity = $ent;
                $employees = $this->employeeService->getAllByEntity($selected_entity, 0);
                $headings[3] = "Entité";
            }

            if (!is_null($sectr) && $sectr != 0) {
                $selected_sector = $sectr;
                $employees = $this->employeeService->getAllBySector($selected_sector, 0);
                $headings[3] = "Secteur";
            }

            if (!is_null($sect) && $sect != 0) {
                $selected_section = $sect;
                $employees = $this->employeeService->getAllBySection($selected_section, 0);
                $headings[3] = "Section";
            }


            // get the columns of the table
            $relations = $this->relationService->getRelationByTable($table->id);
            $i=3;
            foreach ($relations as $relation) {
                $headings[$i] = $relation->column->title;
                $i++;
            }

            $data = [];
            if (!is_null($employees)) {
                foreach ($employees as $employee) {
                    $employeeData[0] = $table->title;
                    $employeeData[1] = $employee->ppr;
                    $employeeData[2] = $employee->lastname.' '.$employee->firstname;
                    switch ($headings[3]) {
                        case "Section":
                            $employeeData[3] = $employee->affectations->where("affectations.state", "=", true)->first()->section->title;
                            break;
                        case "Secteur":
                            $employeeData[3] = $employee->affectations->where("affectations.state", "=", true)->first()->sector->title;
                            break;
                        case "Entité":
                            $employeeData[3] = $employee->affectations->where("affectations.state", "=", true)->first()->entity->title;
                            break;
                        case "Service":
                            $employeeData[3] = $employee->affectations->where("affectations.state", "=", true)->first()->service->title;
                            break;
                    }
                    $data[] = $employeeData;
                }
            }else {
                $employeeData[0] = "";
                $employeeData[1] = "";
                $employeeData[2] = "";

                $data[] = $employeeData;
            }

            $date = new DateTime();
            $current_date =  $date->format('Y-m-d H:i:s');

            return Excel::download(new ModelPerformance($data, $headings), 'canvas_'.$current_date.'.xlsx');


        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
