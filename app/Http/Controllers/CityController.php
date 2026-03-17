<?php

namespace App\Http\Controllers;

use App\Exports\CityExport;
use App\Exports\ServiceExport;
use App\services\CityService;
use App\services\LocalService;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    private CityService $cityService;
    private LocalService $localService;
    private $pages = 5;
    private $rules = [
        'title' => 'required'
    ];

    /**
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService, LocalService $localService)
    {
        $this->cityService = $cityService;
        $this->localService = $localService;
    }

    public function index(Request $request)
    {
        $cities = $this->cityService->getAll($this->pages);
        $locals = $this->localService->getAll(0);

        $local_id = null;
        if ($request->has('lc')) {
            $local_id = $request->query('lc');
            $cities = $this->cityService->getAllByLocal($local_id, $this->pages);
        }

        $filter = "";
        if ($request->has('search')) {
            $filter = $request->query('search');
            $cities = $this->cityService->getAllByFilter($filter, $this->pages);
        }

        return view('app.locals.cities.index', [
            'cities' => $cities,
            'locals' => $locals,
            'total' => $cities->total(),
            'total_locals' => count($locals),
            'local_id' => $local_id,
            'filter' => $filter
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->cityService->create($data)) {
            return redirect()->route('cities.index')->with('success', 'La ville est bien ajoutée');
        }

        return back()->with('error', 'Erreur insertion ville !!!');
    }

    public function delete($id)
    {
        $city = $this->cityService->getOneById($id);

        if (is_null($city)) {
            return back()->with('error', 'Ville introuvable !!');
        }

        if (is_null($this->cityService->delete($id))) {
            return back()->with('error', 'Erreur au suppression du ville !!');
        }

        return redirect()->route('cities.index')->with('success', 'La ville est bien supprimée');
    }

    public function show($id)
    {
        $city = $this->cityService->getOneById($id);

        if (is_null($city)) {
            return back()->with('error', 'Ville introuvable !!');
        }

        return view('app.locals.cities.show', [
            'city' => $city
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $city = $this->cityService->getOneById($id);

        if (is_null($city)) {
            return back()->with('error', 'Ville introuvable !!');
        }

        if ($this->cityService->update($id, $data)) {
            return redirect()->route('cities.index')->with('success', 'La ville est bien modifiée');
        }

        return back()->with('error', 'Erreur modification ville !!!');
    }

    public function download() {
        try {
            //['#', 'Ville', 'Nombre des locaux', 'Nombre effectif'];
            $data = [];
            $cities = $this->cityService->getAll(0);

            $i = 1;
            foreach ($cities as $city) {

                $cityData[0] = $i;
                $cityData[1] = $city->title;
                $cityData[2] = count($city->locals);
                $total_locals = 0;
                foreach ($city->locals as $local) {
                    $total_locals += count($local->employees);
                }
                $cityData[3] = $total_locals;
                $data[] = $cityData;
                $i++;

            }

            $date = new DateTime();
            $current_date =  $date->format('Y-m-d H:i:s');
            return Excel::download(new CityExport($data), 'list_villes_DRI-Marrakech_'.$current_date.'.xlsx');

        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


}
