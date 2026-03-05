<?php

namespace App\Http\Controllers;

use App\services\AffectationService;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    private AffectationService $affectationService;
    private $rules = [
        'employee_id' => 'required',
        'service_id' => 'required',
        'entity_id' => 'required',
        'sector_id' => 'required',
        'section_id' => 'required',
        'affectation_date' => 'required',
    ];

    /**
     * @param AffectationService $affectationService
     */
    public function __construct(AffectationService $affectationService)
    {
        $this->affectationService = $affectationService;
    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->affectationService->create($data);

            if ($result) {
                return back()->with('success', 'Affectation est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion Affectation');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
