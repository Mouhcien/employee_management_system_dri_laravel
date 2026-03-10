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
        'grade_id' => 'required',
        'starting_date' => 'required'
    ];

    /**
     * @param CompetenceService $competenceService
     */
    public function __construct(CompetenceService $competenceService)
    {
        $this->competenceService = $competenceService;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);

        if ($this->competenceService->create($data)) {
            return back()->with('success', 'La competance est bien spécifié');
        }

        return back()->with('error', 'Erreur insertion competance');
    }
}
