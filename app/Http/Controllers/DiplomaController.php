<?php

namespace App\Http\Controllers;

use App\Exports\DiplomaExport;
use App\Exports\GradeExport;
use App\services\DiplomaService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DiplomaController extends Controller
{
    private DiplomaService $diplomaService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param DiplomaService $diplomaService
     */
    public function __construct(DiplomaService $diplomaService)
    {
        $this->diplomaService = $diplomaService;
    }

    public function index(Request $request)
    {
        $diplomas = $this->diplomaService->getAll($this->pages);

        if ($request->has('search'))
            $diplomas = $this->diplomaService->getAllByFilter($request->query('search'), $this->pages);

        return view('app.education.diplomas.index', [
            'diplomas' => $diplomas
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->diplomaService->create($data)) {
            return redirect()->route('settings')->with('success', 'Le diplôme est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion diplôme !!!');
    }

    public function show($id)
    {
        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'Type introuvable !!');
        }

        return view('app.education.diplomas.show', [
            'diploma' => $diploma
        ]);
    }

    public function delete($id)
    {
        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'Type introuvable !!');
        }

        if (is_null($this->diplomaService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du diplôme !!');
        }

        return redirect()->route('settings')->with('success', 'Le diplôme est bien supprimé');
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $diploma = $this->diplomaService->getOneById($id);

        if (is_null($diploma)) {
            return back()->with('error', 'diplôme introuvable !!');
        }

        if ($this->diplomaService->update($id, $data)) {
            return back()->with('success', 'Le diplôme est bien modifier');
        }

        return back()->with('error', 'Erreur midification diplôme !!!');
    }

    public function download($id = null) {
        try {
            $data = [];

            if (is_null($id)) {
                $diplomas = $this->diplomaService->getAll(0);
                foreach ($diplomas as $diploma) {
                    $data = array_merge($data, $this->getDataExport($diploma));
                }
            } else {
                $diploma = $this->diplomaService->getOneById($id);
                if (!$diploma) return back()->with('error', 'Diplôme introuvable !!');
                $data = $this->getDataExport($diploma);
            }

            $current_date = (new DateTime())->format('Y-m-d_H-i-s');
            return Excel::download(new DiplomaExport($data), "Diplômes_DRI-Marrakech_{$current_date}.xlsx");

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    private function getDataExport($diploma) {
        $data = [];

        foreach ($diploma->qualifications as $qualification) {
            if (is_null($qualification->finished_date)) {
                $employee = $qualification->employee;

                $activeAffectation = $employee?->affectations->where('state', '1')->first();

                $row = [
                    $diploma->id,                                  // 0
                    $diploma->title,                               // 1
                    $qualification->option->title ?? '',           // 2
                    $employee->ppr ?? '',                        // 3
                    $employee->cin ?? '',                        // 4
                    $employee->lastname ?? '',                   // 5
                    $employee->firstname ?? '',                  // 6
                    $employee->lastname_arab ?? '',              // 7
                    $employee->firstname_arab ?? '',              // 8
                    $employee->email ?? '',                      // 9
                    $activeAffectation?->service?->title ?? '',  // 10
                    $activeAffectation?->entity?->title ?? '',   // 11
                    $activeAffectation?->sector?->title ?? '',   // 12
                    $activeAffectation?->section?->title ?? '',  // 13
                ];

                $data[] = $row;
            }
        }
        return $data;
    }
}
