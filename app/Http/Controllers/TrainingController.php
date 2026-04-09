<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\services\TrainingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    private TrainingService $trainingService;
    private EmployeeService $employeeService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'theme' => 'required',
        'local' => 'nullable',
        'starting_date' => 'required',
        'end_date' => 'nullable',
    ];

    /**
     * @param TrainingService $trainingService
     * @param EmployeeService $employeeService
     */
    public function __construct(TrainingService $trainingService, EmployeeService $employeeService)
    {
        $this->trainingService = $trainingService;
        $this->employeeService = $employeeService;
    }


    public function index(Request $request) {
        try {

            $employees = $this->employeeService->getAll(0);
            $trainings = $this->trainingService->getAll($this->pages);
            $filter = null;
            $employee_id = null;

            if ($request->has('search')) {
                $filter = $request->query('search');
                $trainings = $this->trainingService->getAllByFilter($filter, $this->pages);
            }

            if ($request->has('agent_id') && $request->query('agent_id') != '-1') {
                $filter = $request->query('search');
                $agent_id = $request->query('agent_id');
                $trainings = $this->trainingService->getAllByFilterAndAgent($filter, $agent_id, $this->pages);
            }


            return view('app.trainings.index', [
                'trainings' => $trainings,
                'filter' => $filter,
                'employees' => $employees,
                'employee_id' => $employee_id
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create() {
        try {

            return view('app.trainings.insert' , [
                'training' => null
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $start = Carbon::parse($data['starting_date']);
            $end = Carbon::parse($data['end_date']);

            $durationInDays = $start->diffInDays($end);

            $data['duration'] = $durationInDays == 0 ? 1 : $durationInDays;

            if (is_null($data['local']))
                $data['local'] = $data['local_type'] ?? 'Marrakech';

            $result = $this->trainingService->create($data);

            if ($result) {
                return redirect()->route('trainings.index')->with('success', "La formation est bien ajouté !!");
            }
            return back()->with('error', "Erreur à linsertion d'une formation !!");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $training = $this->trainingService->getOneById($id);
            if (is_null($training))
                return back()->with('error', "Formation introuvable !!!");

            return view('app.trainings.show', [
                'training' => $training
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id) {
        try {

            $training = $this->trainingService->getOneById($id);
            if (is_null($training))
                return back()->with('error', "Formation introuvable !!!");

            return view('app.trainings.insert', [
                'training' => $training
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $data = $request->validate($this->rules);

            $start = Carbon::parse($data['starting_date']);
            $end = Carbon::parse($data['end_date']);

            $durationInDays = $start->diffInDays($end);

            $data['duration'] = $durationInDays == 0 ? 1 : $durationInDays;

            if (is_null($data['local']))
                $data['local'] = $data['local_type'] ?? 'Marrakech';


            $result = $this->trainingService->update($id, $data);

            if ($result) {
                return redirect()->route('trainings.index')->with('success', "La formation est bien modifié !!");
            }
            return back()->with('error', "Erreur à la mise à d'une formation !!");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete(Request $request, $id) {
        try {

            $training = $this->trainingService->getOneById($id);
            if (is_null($training))
                return back()->with('error', "Formation introuvable !!!");

            $result = $this->trainingService->delete($id);

            if ($result) {
                return redirect()->route('trainings.index')->with('success', "La formation est bien supprimé !!");
            }
            return back()->with('error', "Erreur à la suppression de al formation !!");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function attendences(Request $request, $id) {
        try {

            $employees = $this->employeeService->getAll(0);
            $training = $this->trainingService->getOneById($id);
            if (is_null($training))
                return back()->with('error', "Formation introuvable !!!");

            return view('app.trainings.attendences', [
                'training' => $training,
                'employees' => $employees
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
