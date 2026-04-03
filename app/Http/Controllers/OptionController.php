<?php

namespace App\Http\Controllers;

use App\Exports\DiplomaExport;
use App\Exports\OptionExport;
use App\Models\Employee;
use App\services\OptionService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OptionController extends Controller
{
    private OptionService $optionService;
    private $pages = 10;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param OptionService $optionService
     */
    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
    }

    public function index(Request $request)
    {
        $options = $this->optionService->getAll($this->pages);

        $value = "";
        if ($request->has('q')) {
            $value = $request->query('q');
            $options = $this->optionService->getAllByFilter($value, $this->pages);
        }

        return view('app.education.options.index', [
            'options' => $options,
            'value' => $value
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->optionService->create($data)) {
            return redirect()->route('options.index')->with('success', 'La filière est bien ajouté !!!');
        }

        return back()->with('error', 'Erreur insertion filière !!!');
    }

    public function show($id)
    {
        $option = $this->optionService->getOneById($id);

        if (is_null($option)) {
            return back()->with('error', 'Filière introubable !!');
        }

        return view('app.education.options.show', [
            'option' => $option
        ]);
    }

    public function delete($id)
    {
        $option = $this->optionService->getOneById($id);

        if (is_null($option)) {
            return back()->with('error', 'Filière introubable !!');
        }

        if ($this->optionService->delete($id)) {
            return redirect()->route('options.index')->with('success', 'La filière est bien supprimé !!!');
        }

        return back()->with('error', 'Erreur suppression filière !!!');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|file|mimes:xlsx,csv,xls'
            ]);

            // Read data into array
            $rows = Excel::toArray([], $request->file('file'));

            $count = 0;
            foreach ($rows[0] as $rr) {
                $data['title'] = $rr[0];
                $this->optionService->create($data);
                $count++;
            }

            if ($count == count($rows[0])) {
                return redirect()->route('options.index')->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
            } else {
                return redirect()->route('options.index')->with('error', "filières sont ajouté " . $count . "/" . count($rows[0]) . " !");
            }

        } else {
            return redirect()->route('options.import')->with('error', "Merci de spécifier le fichier excel contenant les employés");
        }
    }

    public function download($id = null) {
        try {
            $data = [];

            if (is_null($id)) {
                $options = $this->optionService->getAll(0);
                foreach ($options as $option) {
                    $data = array_merge($data, $this->getDataExport($option));
                }
            } else {
                $option = $this->optionService->getOneById($id);
                if (!$option) return back()->with('error', 'Diplôme introuvable !!');
                $data = $this->getDataExport($option);
            }

            $current_date = (new DateTime())->format('Y-m-d_H-i-s');
            return Excel::download(new OptionExport($data), "Filières_DRI-Marrakech_{$current_date}.xlsx");

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    private function getDataExport($option) {
        $data = [];

        foreach ($option->qualifications as $qualification) {
            if (is_null($qualification->finished_date)) {
                $employee = $qualification->employee;

                $activeAffectation = $employee?->affectations->where('state', '1')->first();

                $row = [
                    $option->id,                                  // 0
                    $option->title,                               // 1
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
