<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\LocalService;
use Illuminate\Http\Request;

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

    public function index() {
        try {

            $cities = $this->cityService->getAll($this->pages);
            $locals = $this->localService->getAll(0);

            return view('app.locals.cities.index', [
                'cities' => $cities,
                'locals' => $locals,
                'total' => $cities->total(),
                'total_locals' => count($locals)
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->cityService->create($data);

            if ($result) {
                return redirect()->route('cities.index')->with('success', 'La ville est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion ville !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $city = $this->cityService->getOneById($id);

            if (is_null($city)) {
                return back()->with('error', 'Ville introuvable !!');
            }

            $result = $this->cityService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du ville !!');

            return redirect()->route('cities.index')->with('success', 'La ville est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $city = $this->cityService->getOneById($id);

            if (is_null($city)) {
                return back()->with('error', 'Ville introuvable !!');
            }

            return view('app.locals.cities.show', [
                'city' => $city
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $city = $this->cityService->getOneById($id);

            if (is_null($city)) {
                return back()->with('error', 'Ville introuvable !!');
            }

            $result = $this->cityService->update($id, $data);

            if ($result) {
                return redirect()->route('cities.index')->with('success', 'La ville est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification ville !!!');
            }
        }catch (\Exception $exception) {

        }
    }


}
