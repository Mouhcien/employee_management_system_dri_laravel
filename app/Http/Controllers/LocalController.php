<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\LocalService;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    private CityService $cityService;
    private LocalService $localService;
    private $pages = 10;
    private $rules = [
        'title' => 'required',
        'city_id' => 'required'
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
        $cities = $this->cityService->getAll(0);
        $locals = $this->localService->getAll($this->pages);

        return view('app.locals.locals.index', [
            'locals' => $locals,
            'cities' => $cities,
            'total' => $locals->total(),
            'totalCities' => count($locals)
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
}
