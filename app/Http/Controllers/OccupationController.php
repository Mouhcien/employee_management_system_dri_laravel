<?php

namespace App\Http\Controllers;

use App\Exports\CityExport;
use App\Exports\OccupationExport;
use App\services\OccupationService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OccupationController extends Controller
{
    private OccupationService $occupationService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param OccupationService $occupationService
     */
    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    public function index(Request $request)
    {
        $occupations = $this->occupationService->getAll($this->pages);

        if ($request->has('search')) {
            $filter = $request->query('search');
            $occupations = $this->occupationService->getAllByFilter($filter, $this->pages);
        }


        return view('app.occupations.index', [
            'occupations' => $occupations
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->occupationService->create($data)) {
            return redirect()->route('occupations.index')->with('success', 'La fonction est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion occupation !!!');
    }

    public function delete($id)
    {
        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        if (is_null($this->occupationService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du occupation !!');
        }

        return redirect()->route('occupations.index')->with('success', 'La fonction est bien supprimé');
    }

    public function show($id)
    {
        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        return view('app.occupations.show', [
            'occupation' => $occupation
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $occupation = $this->occupationService->getOneById($id);

        if (is_null($occupation)) {
            return back()->with('error', 'Fonction introuvable !!');
        }

        if ($this->occupationService->update($id, $data)) {
            return back()->with('success', 'La fonction est bien modifier');
        }

        return back()->with('error', 'Erreur midification occupation !!!');
    }

    public function download($id = null) {
        try {
            $data = [];

            if (is_null($id)) {
                $occupations = $this->occupationService->getAll(0);
                foreach ($occupations as $occupation) {
                    $data = array_merge($data, $this->getDataExport($occupation));
                }
            } else {
                $occupation = $this->occupationService->getOneById($id);
                if (!$occupation) {
                    return back()->with('error', 'Fonction introuvable !!');
                }
                $data = $this->getDataExport($occupation);
            }

            $current_date = (new DateTime())->format('Y-m-d_H-i-s');
            return Excel::download(new OccupationExport($data), "Fonctions_DRI-Marrakech_{$current_date}.xlsx");

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    private function getDataExport($occupation) {
        $rows = [];

        foreach ($occupation->works as $work) {
            if (is_null($work->terminated_date)) {
                $employee = $work->employee;

                $activeAff = $employee?->affectations->where('state', '1')->first();

                $rows[] = [
                    $occupation->id,                    // 0: #
                    $occupation->title,                 // 1: Fonction
                    $employee?->ppr ?? '',              // 2: PPR
                    $employee?->cin ?? '',              // 3: CIN
                    $employee?->lastname ?? '',         // 4: NOMS FR
                    $employee?->firstname ?? '',        // 5: PRENOMS FR
                    $employee?->lastname_arab ?? '',    // 6: NOMS AR
                    $employee?->firstname_arab ?? '',   // 7: PRENOMS AR
                    $employee?->email ?? '',            // 8: EMAIL
                    $activeAff?->service?->title ?? '', // 9: Service
                    $activeAff?->entity?->title ?? '',  // 10: Entité
                    $activeAff?->sector?->title ?? $activeAff?->section?->title ?? '', // 11: Secteur/Section
                ];
            }
        }

        return $rows;
    }
}
