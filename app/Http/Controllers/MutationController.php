<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use App\Services\EmployeeService;
use App\services\MutationService;
use Illuminate\Http\Request;
use Mockery\Exception;

class MutationController extends Controller
{
    private MutationService $mutationService;
    private EmployeeService $employeeService;
    private AffectationService $affectationService;

    private $pages = 10;

    /**
     * @param MutationService $mutationService
     * @param EmployeeService $employeeService
     * @param AffectationService $affectationService
     */
    public function __construct(MutationService $mutationService, EmployeeService $employeeService, AffectationService $affectationService)
    {
        $this->mutationService = $mutationService;
        $this->employeeService = $employeeService;
        $this->affectationService = $affectationService;
    }

    public function index(Request $request) {
        try {

            $mutations = $this->mutationService->getAll($this->pages);
            $employees = $this->employeeService->getAll(0);

            $filter = null;
            $employee_id = null;

            return view('app.mutations.index', [
                'employees' => $employees,
                'mutations' => $mutations,
                'filter' => $filter,
                'employee_id' => $employee_id,
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function decision($id) {
        try {

            $mutation = $this->mutationService->getOneById($id);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('app.mutations.decision', [
                    'mutation' => $mutation
                ]
            )->setPaper('a4', 'portrait');

            // Download the file
            //return $pdf->download('invoice.pdf');

            return $pdf->stream();

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
