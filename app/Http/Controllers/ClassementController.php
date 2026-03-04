<?php

namespace App\Http\Controllers;

use App\services\ClassementService;
use Illuminate\Http\Request;

class ClassementController extends Controller
{
    private ClassementService $classementService;
    private $rules = [
        'employee_id' => 'required',
        'grade_id' => 'required',
        'starting_date' => 'required'
    ];

    /**
     * @param ClassementService $classementService
     */
    public function __construct(ClassementService $classementService)
    {
        $this->classementService = $classementService;
    }

    public function index() {

    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->classementService->create($data);

            if ($result) {
                return back()->with('success', 'La grade est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion grade');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
