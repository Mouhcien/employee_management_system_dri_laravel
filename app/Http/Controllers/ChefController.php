<?php

namespace App\Http\Controllers;

use App\services\ChefService;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChefController extends Controller
{
    private ChefService $chefService;
    protected ServiceEntityService $serviceEntityService;
    protected EntityService $entityService;
    protected SectorEntityService $sectorEntityService;
    protected SectionEntityService $sectionEntityService;
    private $pages = 10;

    /**
     * @param ChefService $chefService
     */
    public function __construct(ChefService $chefService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectorEntityService $sectorEntityService,
                                SectionEntityService $sectionEntityService)
    {
        $this->chefService = $chefService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->sectionEntityService = $sectionEntityService;
    }

    public function index(Request $request) {
        try {

            $chefs = $this->chefService->getAll($this->pages);

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);

            return view('app.chefs.index', [
                'chefs' => $chefs,
                'services' => $services,
                'entities' => $entities,
                'sections' => $sections,
                'sectors' => $sectors
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function terminate($id) {
        try {
            $chef = $this->chefService->getOneById($id);

            if (is_null($chef)) {
                return back()->with('error', 'Chef introuvable !!');
            }

            $data['state'] = false;
            $data['finished_date'] = now();

            $result = $this->chefService->update($id, $data);

            if ($result) {
                return back()->with('success', 'La periode de chef est terminé !!');
            }else{
                return back()->error('error', 'Erreur !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
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

    public function edit($id) {
        try {
            $chef = $this->chefService->getOneById($id);

            if (is_null($chef)) {
                return back()->with('error', 'Chef introuvable !!');
            }

            return view('app.chefs.edit', [
                'chef' => $chef
            ]);

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $chef = $this->chefService->getOneById($id);
            $employee_id = $chef->employee_id;

            $unity_type = "";
            $unity_id = "";
            if (!is_null($chef->section)) {
                $unity_type = $chef->section->entity->type->title;
                $unity_id = $chef->section_id;
            }

            if (!is_null($chef->sector)) {
                $unity_type = $chef->sector->entity->type->title;
                $unity_id = $chef->sector_id;
            }

            if (!is_null($chef->entity)) {
                $unity_type = $chef->entity->title;
                $unity_id = $chef->entity_id;
            }

            if (is_null($chef)) {
                return back()->with('error', 'Chef introuvable !!');
            }

            $data['decision_file'] = null;
            if ($request->hasFile('decision_file')) {
                $file = $request->file('decision_file');

                $filename = time() . '_chef_' . $unity_type . '_' . $employee_id . '_' . $unity_id . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/unities/'.$unity_type, $filename, 'public');

                $data['decision_file'] = $path;
            }

            if (!is_null($chef->decision_file)) {
                Storage::delete($chef->decision_file);
            }

            if ($request->has('starting_date'))
                $data['starting_date'] = $request->input('starting_date');

            $result = $this->chefService->update($id, $data);

            if ($result) {
                return back()->with('success', 'Les informations du chef est modifié !!');
            }else{
                return back()->error('error', 'Erreur de modification !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function delete($id) {
        try {
            $chef = $this->chefService->getOneById($id);

            if (is_null($chef)) {
                return back()->with('error', 'Chef introuvable !!');
            }

            $result = $this->chefService->delete($id);

            if ($result) {
                return back()->with('success', 'Le chef est supprimé avec success !!');
            }else{
                return back()->error('error', 'Erreur de suppression !!!');
            }

        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
