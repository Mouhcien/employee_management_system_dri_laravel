<?php

namespace App\Http\Controllers;

use App\services\PeriodService;
use Illuminate\Http\Request;
use Mockery\Exception;

class PeriodController extends Controller
{
    private PeriodService $periodService;

    /**
     * @param PeriodService $periodService
     */
    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    public function index() {
        try {

            $periods = $this->periodService->getAll(0);

            return view('app.audit.periods.index', [
                'periods' => $periods,
                'periodObj' => null
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $data['title'] = $request->title;
            if (!is_null($request->starting_date))
                $data['starting_date'] = $request->starting_date;

            if (!is_null($request->end_date))
                $data['end_date'] = $request->end_date;

            if (!is_null($request->year))
                $data['year'] = $request->year;

            $result = $this->periodService->create($data);

            if ($result)
                return back()->with('success', 'Période enregistré avec success !!');
            else
                return back()->with('error', 'Erreur lors du sauvgarde de la période !!');

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id) {
        try {

            $periods = $this->periodService->getAll(0);
            $periodObj = $this->periodService->getOneById($id);
            if (is_null($periodObj))
                return back()->with('error', 'Période introuvable');

            return view('app.audit.periods.index', [
                'periods' => $periods,
                'periodObj' => $periodObj
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $data['title'] = $request->title;
            if (!is_null($request->starting_date))
                $data['starting_date'] = $request->starting_date;

            if (!is_null($request->end_date))
                $data['end_date'] = $request->end_date;

            $result = $this->periodService->update($id, $data);

            if ($result)
                return back()->with('success', 'Période modifié avec success !!');
            else
                return back()->with('error', 'Erreur lors de ma mise a jour de la période !!');

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


}
