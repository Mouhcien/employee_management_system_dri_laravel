<?php

namespace App\Http\Controllers;

use App\services\CityService;
use App\services\EntityService;
use App\services\LevelService;
use App\services\GradeService;
use App\services\DiplomaService;
use App\services\EmployeeService;
use App\services\LocalService;
use App\services\OccupationService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;
    private LocalService $localService;
    private CityService $cityService;
    private OccupationService $occupationService;
    private DiplomaService $diplomaService;
    private GradeService $gradeService;
    private LevelService $levelService;
    private ServiceEntityService $serviceEntityService;
    private EntityService $entityService;
    private SectionEntityService $sectionEntityService;
    private SectorEntityService $sectorEntityService;
    private $pages = 10;

    /**
     * @param EmployeeService $employeeService
     * @param LocalService $localService
     * @param CityService $cityService
     */
    public function __construct(
        EmployeeService $employeeService,
        LocalService $localService,
        CityService $cityService,
        OccupationService $occupationService,
        DiplomaService $diplomaService,
        GradeService $gradeService,
        LevelService $levelService,
        ServiceEntityService $serviceEntityService,
        EntityService $entityService,
        SectionEntityService $sectionEntityService,
        SectorEntityService $sectorEntityService
    ) {
        $this->employeeService = $employeeService;
        $this->localService = $localService;
        $this->cityService = $cityService;
        $this->occupationService = $occupationService;
        $this->diplomaService = $diplomaService;
        $this->gradeService = $gradeService;
        $this->levelService = $levelService;
        $this->serviceEntityService = $serviceEntityService;
        $this->entityService = $entityService;
        $this->sectionEntityService = $sectionEntityService;
        $this->sectorEntityService = $sectorEntityService;
    }


    public function index(Request $request)
    {
        if ($request->has('opt'))
            $this->pages = 12;

        $locals = $this->localService->getAll(0);
        $employees = $this->employeeService->getAll($this->pages);
        $male_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'M'], 0);
        $female_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'F'], 0);
        $cities = $this->cityService->getAll(0);

        $local_id = null;
        $city_id = null;
        $filter = null;

        if ($request->has('ct')) {
            $city_id = $request->query('ct');
            $filter['city_id'] = $city_id;
            $locals = $this->localService->getAllByCity($city_id);
        }

        if ($request->has('lc')) {
            $local_id = $request->query('lc');
            $filter['local_id'] = $local_id;
        }

        if ($request->has('gr')) {
            $genre = $request->query('gr');
            $filter['gender'] = $genre ==  'fml' ? 'F' : 'M';
        }

        if ($request->has('lc') || $request->has('ct') || $request->has('gr')) {
            $employees = $this->employeeService->getAllByFilterAdvanced($filter, $this->pages);
        }

        $template = 'app.employees.index';
        /*
        if ($request->has('opt')) {
            $opt = $request->query('opt');
            if ($opt == 'cards')
                $template = 'app.employees.cards';
        }*/

        return view($template, [
            'locals' => $locals,
            'employees' => $employees,
            'cities' => $cities,
            'femaleCount' => $female_employees->count(),
            'maleCount' => $male_employees->count(),
            'total_employee' => $employees->total(),
            'local_id' => $local_id,
            'city_id' => $city_id,
            'filter_val' => null
        ]);
    }

    public function create()
    {
        try {
            $locals = $this->localService->getAll(0);

            return view('app.employees.insert', [
                'locals' => $locals
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@create: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création.');
        }
    }

    public function store(StoreEmployeeRequest $request)
    {
        try {
            $data = $request->validated();

            $data['firstname_arab'] = $request->input('firstname_arab');
            $data['lastname_arab'] = $request->input('lastname_arab');
            $data['birth_date'] = $request->input('birth_date');
            $data['birth_city'] = $request->input('birth_city');
            $data['gender'] = $request->input('gender');
            $data['sit'] = $request->input('sit');
            $data['hiring_date'] = $request->input('hiring_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');
            $data['status'] = Employee::STATUS_ACTIVE;

            $data['photo'] = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                $filename = time() . '_' . $data['lastname'] . '_' . $data['firstname'] . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }

            $result = $this->employeeService->create($data);

            if ($result) {
                return redirect()->route('employees.index')->with('success', 'Employée est bien ajouté !!!');
            }

            return back()->with('error', 'Erreur insertion employé');

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@store: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'employé.');
        }
    }

    public function edit($id)
    {
        try {
            $locals = $this->localService->getAll(0);
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            return view('app.employees.insert', [
                'locals' => $locals,
                'employee' => $employee
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@edit: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $data = $request->validated();

            $data['firstname_arab'] = $request->input('firstname_arab');
            $data['lastname_arab'] = $request->input('lastname_arab');
            $data['birth_date'] = $request->input('birth_date');
            $data['birth_city'] = $request->input('birth_city');
            $data['gender'] = $request->input('gender');
            $data['sit'] = $request->input('sit');
            $data['hiring_date'] = $request->input('hiring_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');

            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if (!is_null($employee->photo) && Storage::disk('public')->exists($employee->photo)) {
                    Storage::disk('public')->delete($employee->photo);
                }

                $file = $request->file('photo');
                $filename = time() . '_' . $data['lastname'] . '_' . $data['firstname'] . '-' . uniqid() . '.' . $file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }

            $result = $this->employeeService->update($id, $data);

            if ($result) {
                return redirect()->route('employees.index')->with('success', 'Employée est bien modifié !!!');
            }

            return back()->with('error', 'Erreur insertion employé');

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@update: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification de l\'employé.');
        }
    }

    public function delete($id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $result = $this->employeeService->delete($id);

            if ($result) {
                if (!is_null($employee->photo)) {
                    Storage::disk('public')->delete($employee->photo);
                }
                return back()->with('success', 'Employé est supprimé avec success');
            }

            return back()->with('error', 'Erreur suppression employé');

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@delete: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    public function show($id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            $occupations = $this->occupationService->getAll(0);
            $diplomas = $this->diplomaService->getAll(0);
            $grades = $this->gradeService->getAll(0);
            $levels = $this->levelService->getAll(0);

            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            return view('app.employees.show', [
                'employee' => $employee,
                'occupations' => $occupations,
                'diplomas' => $diplomas,
                'grades' => $grades,
                'levels' => $levels,
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@show: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function unities(Request $request, $id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            $service_id = null;
            $entity_id = null;

            if ($request->has('srv')) {
                $service_id = $request->query('srv');
                $entities = $this->entityService->getAllByService($service_id, 0);
            }

            if ($request->has('ent')) {
                $entity_id = $request->query('ent');
                $sectors = $this->sectorEntityService->getAllByEntity($entity_id, 0);
                $sections = $this->sectionEntityService->getAllByEntity($entity_id, 0);
            }

            return view('app.employees.unities', [
                'employee' => $employee,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections,
                'affectationObj' => null,
                'service_id' => $service_id,
                'entity_id' => $entity_id
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@unities: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function search(Request $request) {
        try {

            $locals = $this->localService->getAll(0);
            $male_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'M'], 0);
            $female_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'F'], 0);
            $cities = $this->cityService->getAll(0);

            $query = $request->input('employee_search');

            $employees = $this->employeeService->getAllByFilterValue($query, $this->pages);

            return view('app.employees.index', [
                'locals' => $locals,
                'employees' => $employees,
                'cities' => $cities,
                'femaleCount' => $female_employees->count(),
                'maleCount' => $male_employees->count(),
                'total_employee' => $employees->total(),
                'local_id' => null,
                'city_id' => null,
                'filter_val' => $query
            ]);

        }catch (\Exception $exception) {
            Log::error('Error in EmployeeController@search: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

}
