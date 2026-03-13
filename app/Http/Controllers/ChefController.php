<?php

namespace App\Http\Controllers;

use App\services\ChefService;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    private ChefService $chefService;

    /**
     * @param ChefService $chefService
     */
    public function __construct(ChefService $chefService)
    {
        $this->chefService = $chefService;
    }


    public function store(Request $request) {
        try {

            $employee_id = $request->input('employee_id');
            $unity_type = $request->input('unity_type');
            $unity_id = $request->input('unity_id');

            $data['employee_id'] = $employee_id;
            $data['starting_date'] = $request->input('starting_date');

            if ($unity_type == "service"){
                $data['service_id'] = $unity_id;
                $data['entity_id'] = null;
                $data['section_id'] = null;
                $data['sector_id'] = null;
            }

            if ($unity_type == "entity") {
                $data['entity_id'] = $unity_id;
                $data['service_id'] = null;
                $data['section_id'] = null;
                $data['sector_id'] = null;
            }

            if ($unity_type == "section") {
                $data['section_id'] = $unity_id;
                $data['service_id'] = null;
                $data['entity_id'] = null;
                $data['sector_id'] = null;
            }

            if ($unity_type == "sector") {
                $data['sector_id'] = $unity_id;
                $data['service_id'] = null;
                $data['entity_id'] = null;
                $data['section_id'] = null;
            }

            $data['decision_file'] = null;
            if ($request->hasFile('decision_file')) {
                $file = $request->file('decision_file');

                $filename = time() . '_chef_' . $unity_type . '_' . $employee_id . '_' . $unity_id . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/unities/'.$unity_type, $filename, 'public');

                $data['decision_file'] = $path;
            }

            $result = $this->chefService->create($data);

            if ($result) {
                return back()->with('success', "L'affectation est bien faite !!");
            }else{
                return back()->with('error', "erreur lors de l'affectation !!");
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
