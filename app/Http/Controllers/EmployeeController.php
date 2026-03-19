<?php

namespace App\Http\Controllers;

use App\services\CategoryService;
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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
    private CategoryService $categoryService;
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
        SectorEntityService $sectorEntityService,
        CategoryService $categoryService
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
        $this->categoryService = $categoryService;
    }


    public function index(Request $request)
    {

        if ($request->has('opt')) {
            if ($request->query('opt') == 'list') {
                $request->session()->put('opt', 'list');
            } elseif ($request->query('opt') == 'cards') {
                $this->pages = 12;
                $request->session()->put('opt', 'cards');
            }elseif ($request->query('opt') == 'empcrd') {
                $this->pages = 0;
                $request->session()->put('opt', 'empcrd');
            }
        } else {
            if ($request->session()->has('opt')) {
                if ($request->session()->get('opt') == 'list') {
                    $request->session()->put('opt', 'list');
                }elseif ($request->session()->get('opt') == 'cards') {
                    $this->pages = 12;
                    $request->session()->put('opt', 'cards');
                }elseif ($request->session()->get('opt') == 'empcrd') {
                    $this->pages = 0;
                    $request->session()->put('opt', 'empcrd');
                }
            }
        }

        $locals = $this->localService->getAll(0);
        $employees = $this->employeeService->getAll($this->pages);
        $male_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'M'], 0);
        $female_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'F'], 0);
        $cities = $this->cityService->getAll(0);
        $categories = $this->categoryService->getAll(0);

        $local_id = null;
        $city_id = null;
        $filter = null;

        if ($request->has('ct')) {
            $city_id = $request->query('ct');
            $filter['city_id'] = $city_id;
            $locals = $this->localService->getAllByCity($city_id, 0);
        }

        if ($request->has('lc')) {
            $local_id = $request->query('lc');
            $filter['local_id'] = $local_id;
        }

        if ($request->has('gr')) {
            $genre = $request->query('gr');
            $filter['gender'] = $genre == 'fml' ? 'F' : 'M';
        }

        if ($request->has('lc') || $request->has('ct') || $request->has('gr')) {
            $employees = $this->employeeService->getAllByFilterAdvanced($filter, $this->pages);
        }

        $employeeObj = null;
        if ($request->has('emp')) {
            $employee_id = $request->query('emp');
            $employeeObj = $this->employeeService->getOneById($employee_id);
        }

        $template = 'app.employees.index';

        return view($template, [
            'locals' => $locals,
            'employees' => $employees,
            'cities' => $cities,
            'categories' => $categories,
            'femaleCount' => $female_employees->count(),
            'maleCount' => $male_employees->count(),
            'total_employee' => $this->pages == 0 ? $employees->count() : $employees->total(),
            'local_id' => $local_id,
            'city_id' => $city_id,
            'filter_val' => null,
            'employeeObj' => $employeeObj
        ]);
    }

    public function create()
    {
        try {
            $locals = $this->localService->getAll(0);
            $categories = $this->categoryService->getAll(0);

            return view('app.employees.insert', [
                'locals' => $locals,
                'categories' => $categories,
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
            $data['hiring_public_date'] = $request->input('hiring_public_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');
            $data['category_id'] = $request->input('category_id');
            $data['status'] = Employee::STATUS_ACTIVE;

            $data['photo'] = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                $filename = $data['ppr'].$file->extension();
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
            $categories = $this->categoryService->getAll(0);

            if (is_null($employee)) {
                return back()->with('error', 'Employé introuvable');
            }

            return view('app.employees.insert', [
                'locals' => $locals,
                'employee' => $employee,
                'categories' => $categories,
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
            $data['hiring_public_date'] = $request->input('hiring_public_date');
            $data['address'] = $request->input('address');
            $data['tel'] = $request->input('tel');
            $data['city'] = $request->input('city');
            $data['email'] = $request->input('email');
            $data['category_id'] = $request->input('category_id');
            $data['status'] = Employee::STATUS_ACTIVE;

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

    public function search(Request $request)
    {
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

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@search: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function import(Request $request)
    {
        try {

            $locals = $this->localService->getAll(0);
            return view('app.employees.import', [
                'locals' => $locals
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@import: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    //Par local
    public function importation(Request $request)
    {
        try {

            if ($request->hasFile('file')) {

                $request->validate([
                    'file' => 'required|file|mimes:xlsx,csv,xls'
                ]);

                // Read data into array
                $rows = Excel::toArray([], $request->file('file'));

                $count = 0;
                foreach ($rows[0] as $rr) {
                    $data['local_id'] = $request->input('local_id');
                    $data['ppr'] = $rr[0];
                    $data['cin'] = $rr[1];
                    $data['firstname'] = $rr[12];
                    $data['lastname'] = $rr[11];

                    $data['firstname_arab'] = $rr[14];
                    $data['lastname_arab'] = $rr[13];
                    $data['birth_date'] = Date::excelToDateTimeObject($rr[3])->format('Y-m-d');
                    $data['birth_city'] = $rr[4];
                    $data['gender'] = $rr[5];
                    $data['sit'] = $rr[6];
                    $data['hiring_date'] = Date::excelToDateTimeObject((float) $rr[7])->format('Y-m-d');
                    $data['address'] = $rr[8];
                    $data['tel'] = $rr[9];
                    $data['email'] = $rr[10];
                    $data['status'] = Employee::STATUS_ACTIVE;

                    $data['photo'] = null;
                    $this->employeeService->create($data);
                    $count++;
                }

                if ($count == count($rows[0])) {
                    return redirect()->route('employees.index')->with('success', "Importation est bien faite!!  " . $count . "/" . count($rows[0]) . " !");
                } else {
                    return redirect()->route('employees.index')->with('error', "Employé sont ajouté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('employees.import')->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }


        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@importation: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.' . $exception->getMessage());
        }
    }

}
