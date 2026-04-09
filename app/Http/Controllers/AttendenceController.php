<?php

namespace App\Http\Controllers;

use App\services\AttendenceService;
use App\Services\EmployeeService;
use App\services\TrainingService;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
    private AttendenceService $attendenceService;
    private EmployeeService $employeeService;
    private TrainingService $trainingService;

    /**
     * @param AttendenceService $attendenceService
     * @param EmployeeService $employeeService
     * @param TrainingService $trainingService
     */
    public function __construct(AttendenceService $attendenceService, EmployeeService $employeeService, TrainingService $trainingService)
    {
        $this->attendenceService = $attendenceService;
        $this->employeeService = $employeeService;
        $this->trainingService = $trainingService;
    }


    public function store(Request $request, $id) {
        try {

            $training = $this->trainingService->getOneById($id);
            if (is_null($training))
                return back()->with('error', "Formation Introuvable !!");

            $employee_ids = $request->employee_ids;
            $count = 0;
            foreach ($employee_ids as $employee_id) {
                $data['employee_id'] = $employee_id;
                $data['training_id'] = $id;

                $this->attendenceService->create($data);
                $count++;
            }

            if ($count == count($employee_ids))
                return redirect()->route('trainings.index')->with('success', "Les $count agents sont ajouté au formation");
            else
                return back()->with('error', "Erreur au formation");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $attendence = $this->attendenceService->getOneById($id);
            if (is_null($attendence))
                return back()->with('error', "Participation introuvable !!!");

            $result = $this->attendenceService->delete($id);

            if ($result) {
                return redirect()->route('trainings.index')->with('success', "La participation au formation est bien supprimé !!");
            }
            return back()->with('error', "Erreur à la suppression de la participation au formation !!");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
