<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\services\HolidayService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    private HolidayService $holidayService;
    private EmployeeService $employeeService;

    private $pages = 10;

    /**
     * @param HolidayService $holidayService
     * @param EmployeeService $employeeService
     */
    public function __construct(HolidayService $holidayService, EmployeeService $employeeService)
    {
        $this->holidayService = $holidayService;
        $this->employeeService = $employeeService;
    }

    public function index(Request $request) {
        try {

            $employees = $this->employeeService->getAllExternEmployees($this->pages);
            $holidays = $this->holidayService->getAll($this->pages);

            return view('app.holidays.index', [
                'holidays' => $holidays,
                'employees' => $employees
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create() {
        try {

            $employees = $this->employeeService->getAllExternEmployees(0);

            return view('app.holidays.insert', [
                'employees' => $employees
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate([
                'employee_id'   => 'required|exists:employees,id',
                'year'          => 'required|integer|min:2000|max:2099',
                'starting_date' => 'required|date',
                'total_year'    => 'required|integer|min:0',
                'demand'        => 'required|integer|min:0',
                'total_rest'    => 'required|integer',
            ]);

            $result = $this->holidayService->create($data);

            if ($result) {
                return redirect()->route('holidays.index')
                    ->with('success', 'Le congé de l\'agent a été enregistré avec succès.');
            }else {
                return back()->with('error', "Erreur lors d'insertion des données !!!");
            }



        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
