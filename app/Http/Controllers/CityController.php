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

    public function index()
    {
        $cities = $this->cityService->getAll($this->pages);
        $locals = $this->localService->getAll(0);

        return view('app.locals.cities.index', [
            'cities' => $cities,
            'locals' => $locals,
            'total' => $cities->total(),
            'total_locals' => count($locals)
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


}
