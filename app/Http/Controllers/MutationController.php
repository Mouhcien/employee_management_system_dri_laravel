<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use App\Services\EmployeeService;
use App\services\MutationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class MutationController extends Controller
{
    private MutationService $mutationService;
    private EmployeeService $employeeService;
    private AffectationService $affectationService;

    private $pages = 10;
    private $rules = [
        'employee_id' => 'required',
        'entity_name' => 'required',
        'direction_name' => 'required',
        'city_name' => 'required',
        'starting_date' => 'required',
    ];

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
            //$employees = $this->employeeService->getAll(0);

            $filter = null;
            if ($request->has('fltr')) {
                $filter['fltr'] = $request->query('fltr');
                $mutations = $this->mutationService->getAllByFilter($filter, $this->pages);
            }

            if ($request->has('type')) {
                $filter['type'] = $request->query('type');
                $mutations = $this->mutationService->getAllByFilter($filter, $this->pages);
            }

            return view('app.mutations.index', [
                //'employees' => $employees,
                'mutations' => $mutations,
                'fltr' => $filter['fltr'] ?? '',
                //'employee_id' => $employee_id,
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

    public function create() {
        try {

            $employees = $this->employeeService->getAll(0);

            return view('app.mutations.insert', [
                'employees' => $employees
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request){
        try {

            DB::beginTransaction();
            $data = $request->validate($this->rules);

            $affectation = $this->affectationService->getOneByEmployeeId($data['employee_id']);
            if (is_null($affectation)) {
                return back()->with('error', "Affectation introuvable !!");
            }
            $data['from_affectation_id'] = $affectation->id;
            $data['type'] = 'E';

            $result = $this->mutationService->create($data);
            if ($result) {
                //Change the status of the employee
                $this->employeeService->changeStateMode($data['employee_id'], -8);

                DB::commit();
                return redirect()->route('mutations.index')->with('success', "La mutation est bien enregistré !!");
            }

            return back()->with('error', "Erreur lors de l'enrgistrement de la mutation !!!");


        }catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

}
