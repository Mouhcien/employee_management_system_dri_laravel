<?php

namespace App\Http\Controllers;

use App\services\CompetenceService;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    private CompetenceService $competenceService;
    private $rules = [
        'employee_id' => 'required',
        'level_id' => 'required',
        'starting_date' => 'required'
    ];

    /**
     * @param CompetenceService $competenceService
     */
    public function __construct(CompetenceService $competenceService)
    {
        $this->competenceService = $competenceService;
    }

    public function index() {

    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->competenceService->create($data);

            if ($result) {
                return back()->with('success', 'La competence est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion competence');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
