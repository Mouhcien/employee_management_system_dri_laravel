<?php

namespace App\Http\Controllers;

use App\services\HabilitationService;
use Illuminate\Http\Request;

class HabilitationController extends Controller
{

    private HabilitationService $habilitationService;

    /**
     * @param HabilitationService $habilitationService
     */
    public function __construct(HabilitationService $habilitationService)
    {
        $this->habilitationService = $habilitationService;
    }


    public function index() {

    }

    public function store(Request $request) {
        try {
            $data['profile_id'] = $request->profile_id;
            $rules = $request->rule_id;

            $result = false;
            foreach ($rules as $rule) {
                $data['rule_id'] = $rule;
                $result = $this->habilitationService->create($data);
            }

            return back()->with('succes', "Affectation est bien faite !!");
            if ($result)
                return back()->with('succes', "Affectation est bien faite !!");
            else
                return back()->with('error', "Erreur lors de l'affectation des habilitaions !!");

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
