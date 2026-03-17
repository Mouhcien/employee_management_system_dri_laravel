<?php

namespace App\Http\Controllers;

use App\Exports\LocalExport;
use App\Exports\ServiceExport;
use App\services\CityService;
use App\Services\EmployeeService;
use App\services\LocalService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LocalController extends Controller
{
    private CityService $cityService;
    private LocalService $localService;
    private EmployeeService $employeeService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'city_id' => 'required'
    ];

    /**
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService, LocalService $localService, EmployeeService $employeeService)
    {
        $this->cityService = $cityService;
        $this->localService = $localService;
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $cities = $this->cityService->getAll(0);
        $locals = $this->localService->getAll($this->pages);
        $employees = $this->employeeService->getAll(0);

        $city_id = null;
        if ($request->has('cty')) {
            $city_id = $request->query('cty');
            $locals = $this->localService->getAllByCity($city_id, $this->pages);
        }

        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $locals = $this->localService->getAllByFilter($filter, $this->pages);
        }

        return view('app.locals.locals.index', [
            'locals' => $locals,
            'cities' => $cities,
            'total' => $locals->total(),
            'totalCities' => count($locals),
            'totalEmployee' => count($employees),
            'city_id' => $city_id,
            'filter' => $filter
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->localService->create($data)) {
            return redirect()->route('locals.index')->with('success', 'Le local est bien ajouté');
        }

        return back()->with('error', 'Erreur insertion local !!!');
    }

    public function delete($id)
    {
        $local = $this->localService->getOneById($id);

        if (is_null($local)) {
            return back()->with('error', 'Local introuvable !!');
        }

        if (is_null($this->localService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du local !!');
        }

        return redirect()->route('locals.index')->with('success', 'Le local est bien supprimé');
    }

    public function show($id)
    {
        $cities = $this->cityService->getAll(0);
        $local = $this->localService->getOneById($id);

        if (is_null($local)) {
            return back()->with('error', 'Local introuvable !!');
        }

        return view('app.locals.locals.show', [
            'local' => $local,
            'cities' => $cities
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $local = $this->localService->getOneById($id);

        if (is_null($local)) {
            return back()->with('error', 'Local introuvable !!');
        }

        if ($this->localService->update($id, $data)) {
            return redirect()->route('locals.index')->with('success', 'Le local est bien modifier');
        }

        return back()->with('error', 'Erreur midification local !!!');
    }

    public function download() {
        try {
            //['#', 'Local', 'Ville', 'Nombre effectif'];
            $data = [];
            $locals = $this->localService->getAll(0);

            $i = 1;
            foreach ($locals as $local) {

                $localData[0] = $i;
                $localData[1] = $local->title;
                $localData[2] = $local->city->title;
                $localData[3] = count($local->employees);
                $data[] = $localData;
                $i++;

            }

            $date = new DateTime();
            $current_date =  $date->format('Y-m-d H:i:s');
            return Excel::download(new LocalExport($data), 'list_locaux_DRI-Marrakech_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
