<?php

namespace App\Http\Controllers;

use App\services\ChefService;
use App\Services\EmployeeService;
use App\services\EntityService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\TempService;
use Illuminate\Http\Request;

class TempController extends Controller
{
    private TempService $tempService;
    private ChefService $chefService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectionEntityService $sectionEntityService;
    private SectorEntityService $sectorEntityService;
    private EmployeeService $employeeService;
    private $pages = 10;

    /**
     * @param TempService $tempService
     * @param ChefService $chefService
     */
    public function __construct(TempService $tempService,
                                ChefService $chefService,
                                ServiceEntityService $serviceEntityService,
                                EntityService $entityService,
                                SectionEntityService $sectionEntityService,
                                SectorEntityService $sectorEntityService,
                                EmployeeService $employeeService)
    {
        $this->tempService = $tempService;
        $this->chefService = $chefService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->sectorEntityService = $sectorEntityService;
        $this->employeeService = $employeeService;
    }

    public function index(Request $request) {
        try {

            $temps = $this->tempService->getAll($this->pages);
            $chefs = $this->chefService->getAll(0);

            return view('app.temps.index', [
                'temps' => $temps,
                'chefs' => $chefs
            ]);
        }catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function create(Request $request) {
        try {

            $temps = $this->tempService->getAll($this->pages);
            $chefs = $this->chefService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);

            $employees = $this->employeeService->getAll(0);

            return view('app.temps.insert', [
                'temps' => $temps,
                'chefs' => $chefs,
                'services' => $services,
                'entities' => $entities,
                'sections' => $sections,
                'sectors' => $sectors,
                'employees' => $employees
            ]);
        }catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function store(Request $request) {
        try {

            $employee_id = $request->input('employee_id');
            $chef_id = $request->input('chef_id');

            $employee = $this->employeeService->getOneById($employee_id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable !!!');
            }

            $chef = $this->chefService->getOneById($chef_id);
            if (is_null($chef)) {
                return back()->with('error', 'Chef introuvable !!!');
            }

            $data['employee_id'] = $employee_id;
            $data['chef_id'] = $chef_id;
            $data['starting_date'] = $request->input('starting_date');
            $data['finished_date'] = $request->input('finished_date');

            $data['file'] = null;
            if ($request->hasFile('decision_file')) {
                $file = $request->file('decision_file');

                $filename = time() . '_chef_interim_' . $chef_id . '_' . $employee_id . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/temps', $filename, 'public');

                $data['file'] = $path;
            }

            $result = $this->tempService->create($data);

            if ($result) {
                return redirect()->route('temps.index')->with('success', "L'affectation est bien faite !!");
            }else{
                return back()->with('error', "erreur lors de l'affectation !!");
            }

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
