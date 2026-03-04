<?php

namespace App\Http\Controllers;

use App\services\WorkService;
use Illuminate\Http\Request;

class WorkController extends Controller
{

    private WorkService $workService;
    private $rules = [
        'employee_id' => 'required',
        'occupation_id' => 'required',
        'starting_date' => 'required'
    ];

    /**
     * @param WorkService $workService
     */
    public function __construct(WorkService $workService)
    {
        $this->workService = $workService;
    }

    public function index() {

    }

    public function store(Request $request) {
        try {

            $data = $request->validate($this->rules);

            $result = $this->workService->create($data);

            if ($result) {
                return back()->with('success', 'La fonction est bien spécifié');
            }

            return back()->with('error', 'Erreur insertion fonction');

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
