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

    public function index() {
        try {
            $options = $this->optionService->getAll($this->pages);

            return view('app.education.options.index', [
                'options' => $options
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->optionService->create($data);

            if ($result) {
                return redirect()->route('options.index')->with('success', 'La filière est bien ajouté !!!');
            }else{
                return back()->with('error', 'Erreur insertion filière !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $option = $this->optionService->getOneById($id);

            if (is_null($option)) {
                return back()->with('error', 'Filière introubable !!');
            }

            return view('app.education.options.show', [
                'option' => $option
            ]);


        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {

            $option = $this->optionService->getOneById($id);

            if (is_null($option)) {
                return back()->with('error', 'Filière introubable !!');
            }

            $result = $this->optionService->delete($id);

            if ($result) {
                return redirect()->route('options.index')->with('success', 'La filière est bien supprimé !!!');
            }else{
                return back()->with('error', 'Erreur suppression filière !!!');
            }


        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function import(Request $request) {
        try {

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
                    return redirect()->route('options.index')->with('success', "Importation est bien faite!!  ".$count."/".count($rows[0])." !");
                }else{
                    return redirect()->route('options.index')->with('error', "filières sont ajouté ".$count."/".count($rows[0])." !");
                }

            }else{
                return redirect()->route('options.import')->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }


        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
