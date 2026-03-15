<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\services\LocalService;

class DashboardController extends Controller
{

    private EmployeeService $employeeService;
    private LocalService $localService;

    /**
     * @param EmployeeService $employeeService
     * @param LocalService $localService
     */
    public function __construct(EmployeeService $employeeService, LocalService $localService)
    {
        $this->employeeService = $employeeService;
        $this->localService = $localService;
    }


    public function index() {

        $employees = $this->employeeService->getAll(0);
        $locals = $this->localService->getAll(0);

        return view('app.dashboard', [
            'totalEmployees' => $employees->count(),
            'totalLocals' => $locals->count()
        ]);
    }
}
