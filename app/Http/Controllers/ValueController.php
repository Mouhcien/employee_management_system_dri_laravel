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

            $selected_table = null;
            $tableObj = null;
            if ($request->has('tbl')) {
                $selected_table = $request->query('tbl');
                $tableObj = $this->tableService->getOneById($selected_table);
            }

            return view('app.audit.values.index', [
                'tables' => $tables,
                'periods' => $periods,
                'tableObj' => $tableObj,
                'selected_table' => $selected_table,
                'employees' => $employees
            ]);


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
