<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\services\OptionService;
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

    public function index()
    {
        $options = $this->optionService->getAll($this->pages);

        return view('app.education.options.index', [
            'options' => $options
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

}
