<?php

namespace App\Http\Controllers;

use App\services\QualificationService;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    private QualificationService $qualificationService;
    private $rules = [
        'employee_id' => 'required',
        'diploma_id' => 'required',
        'year' => 'required'
    ];

    /**
     * @param QualificationService $qualificationService
     */
    public function __construct(QualificationService $qualificationService)
    {
        $this->qualificationService = $qualificationService;
    }

    public function index() {

    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->qualificationService->create($data);

            if ($result) {
                return back()->with('success', 'Le dipôme est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion dipôme');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
