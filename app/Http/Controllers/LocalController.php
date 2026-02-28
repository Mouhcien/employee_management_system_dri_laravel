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

    public function index() {
        try {

            $cities = $this->cityService->getAll(0);
            $locals = $this->localService->getAll($this->pages);

            return view('app.locals.locals.index', [
                'locals' => $locals,
                'cities' => $cities,
                'total' => $locals->total(),
                'totalCities' => count($locals)
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate($this->rules);

            $result = $this->localService->create($data);

            if ($result) {
                return redirect()->route('locals.index')->with('success', 'Le local est bien ajouté');
            }else{
                return back()->with('error', 'Erreur insertion local !!!');
            }
        }catch (\Exception $exception) {

        }
    }

    public function delete($id) {
        try {

            $local = $this->localService->getOneById($id);

            if (is_null($local)) {
                return back()->with('error', 'Local introuvable !!');
            }

            $result = $this->localService->delete($id);

            if (is_null($result))
                return back()->with('error', 'Erreur au suppression du local !!');

            return redirect()->route('locals.index')->with('success', 'Le local est bien supprimé');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show($id) {
        try {

            $cities = $this->cityService->getAll(0);
            $local = $this->localService->getOneById($id);

            if (is_null($local)) {
                return back()->with('error', 'Local introuvable !!');
            }

            return view('app.locals.locals.show', [
                'local' => $local,
                'cities' => $cities
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate($this->rules);

            $local = $this->localService->getOneById($id);

            if (is_null($local)) {
                return back()->with('error', 'Local introuvable !!');
            }

            $result = $this->localService->update($id, $data);

            if ($result) {
                return redirect()->route('locals.index')->with('success', 'Le local est bien modifier');
            }else{
                return back()->with('error', 'Erreur midification local !!!');
            }
        }catch (\Exception $exception) {

        }
    }
}
