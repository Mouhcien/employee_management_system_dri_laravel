<?php

namespace App\Http\Controllers;


use App\services\AffectationService;
use App\services\CategoryService;
use App\services\CityService;
use App\services\CompetenceService;
use App\services\EntityService;
use App\services\LevelService;
use App\services\GradeService;
use App\services\DiplomaService;
use App\services\EmployeeService;
use App\services\LocalService;
use App\services\OccupationService;
use App\services\OptionService;
use App\services\QualificationService;
use App\services\SectionEntityService;
use App\services\SectorEntityService;
use App\services\ServiceEntityService;
use App\services\WorkService;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

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
    private OptionService $optionService;
    private WorkService $workService;
    private CompetenceService $competenceService;
    private QualificationService $qualificationService;
    private AffectationService $affectationService;
    private $pages = 10;
    private $rules = [
        'ppr' => 'required',
        'cin' => 'required',
        'firstname' => 'required',
        'lastname' => 'required',
        'local_id' => 'required'
    ];

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
        CategoryService $categoryService,
        OptionService $optionService,
        WorkService $workService,
        CompetenceService $competenceService,
        QualificationService $qualificationService,
        AffectationService $affectationService,
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
        $this->optionService = $optionService;
        $this->workService = $workService;
        $this->competenceService = $competenceService;
        $this->qualificationService = $qualificationService;
        $this->affectationService = $affectationService;
    }


    public function index(Request $request)
    {

        $this->pages = $this->setEmployeeCardSession($request);

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

        if ($request->has('_token')){
            $employees = $this->employeeService->sortEmployeesByOption($request, $this->pages);
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

    public function store(Request $request)
    {
        try {

            $data = $request->validate($this->rules);

            $data['firstname'] = $request->input('firstname');
            $data['lastname'] = $request->input('lastname');
            $data['ppr'] = $request->input('ppr');
            $data['cin'] = $request->input('cin');
            $data['local_id'] = $request->input('local_id');
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
            $data['email'] = $request->input('email');
            $data['category_id'] = $request->input('category_id');
            $data['status'] = Employee::STATUS_ACTIVE;
            $data['commission_card'] = $request->input('commission_card');

            $data['photo'] = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                $filename = $data['ppr'].".".$file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }

            $result = $this->employeeService->create($data);

            if ($result) {
                $employee_id = $this->employeeService->getLatestInserted();
                return redirect()->route('employees.unities', $employee_id)->with('success', 'Agente est bien ajouté !!!');
            }

            return back()->with('error', 'Erreur insertion employé');

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@store: ' . $exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $locals = $this->localService->getAll(0);
            $employee = $this->employeeService->getOneById($id);
            $categories = $this->categoryService->getAll(0);

            if (is_null($employee)) {
                return back()->with('error', 'Agent introuvable');
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

    public function update(Request $request, $id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Agent introuvable');
            }

            $data = $request->validate($this->rules);

            $data['firstname'] = $request->input('firstname');
            $data['lastname'] = $request->input('lastname');
            $data['ppr'] = $request->input('ppr');
            $data['cin'] = $request->input('cin');
            $data['local_id'] = $request->input('local_id');
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
            $data['commission_card'] = $request->input('commission_card');

            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if (!is_null($employee->photo) && Storage::disk('public')->exists($employee->photo)) {
                    Storage::disk('public')->delete($employee->photo);
                }

                $file = $request->file('photo');

                $filename = $data['ppr'].".".$file->extension();
                $path = $file->storeAs('photos/employees', $filename, 'public');

                $data['photo'] = $path;
            }else{
                $data['photo'] = $employee->photo;
            }

            $result = $this->employeeService->update($id, $data);

            if ($result) {
                return redirect()->route('employees.index')->with('success', 'Agente est bien modifié !!!');
            }

            return back()->with('error', 'Erreur insertion employé');

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@update: ' . $exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee)) {
                return back()->with('error', 'Agent introuvable');
            }

            $result = $this->employeeService->delete($id);

            if ($result) {
                if (!is_null($employee->photo)) {
                    Storage::disk('public')->delete($employee->photo);
                }
                return back()->with('success', 'Agent est supprimé avec success');
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
            $options = $this->optionService->getAll(0);

            if (is_null($employee)) {
                return back()->with('error', 'Agent introuvable');
            }

            return view('app.employees.show', [
                'employee' => $employee,
                'occupations' => $occupations,
                'diplomas' => $diplomas,
                'grades' => $grades,
                'levels' => $levels,
                'options' => $options
            ]);

        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@show: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function history($id)
    {
        try {
            $employee = $this->employeeService->getOneById($id);
            $occupations = $this->occupationService->getAll(0);
            $diplomas = $this->diplomaService->getAll(0);
            $grades = $this->gradeService->getAll(0);
            $levels = $this->levelService->getAll(0);
            $options = $this->optionService->getAll(0);

            if (is_null($employee)) {
                return back()->with('error', 'Agent introuvable');
            }

            return view('app.employees.show-history', [
                'employee' => $employee,
                'occupations' => $occupations,
                'diplomas' => $diplomas,
                'grades' => $grades,
                'levels' => $levels,
                'options' => $options
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
                return back()->with('error', 'Agent introuvable');
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

    public function import_all(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->route('employees.index')->with('error', "Merci de spécifier le fichier excel.");
        }

        $request->validate(['file' => 'required|file|mimes:xlsx,csv,xls']);

        try {
            $rows = Excel::toArray([], $request->file('file'))[0];
            array_shift($rows); // Remove header row

            $totalRows = count($rows);
            $importedCount = 0;

            DB::beginTransaction();

            foreach ($rows as $row) {
                if (empty(array_filter($row))) continue;

                $ppr = trim($row[0] ?? '');
                if (empty($ppr)) continue;

                $local = $this->localService->getByTitle(trim($row[23] ?? ''));
                $occupation = $this->occupationService->getByTitle(trim($row[11] ?? ''));
                $grade = $this->gradeService->getByTitle(trim($row[19] ?? ''));
                $diploma = $this->diplomaService->getByTitle(trim($row[22] ?? ''));
                $option = $this->optionService->getByTitle(trim($row[21] ?? ''));

                $service = $this->serviceEntityService->getByTitle(trim($row[13] ?? ''));
                $entityTitle = trim($row[15] ?? '');
                $sector = $this->sectorEntityService->getByTitle($entityTitle);
                $section = $this->sectionEntityService->getByTitle($entityTitle);
                $entity = $this->entityService->getByTitle($entityTitle);

                $employeeData = [
                    'firstname'      => $row[33],
                    'lastname'       => $row[32],
                    'firstname_arab' => $row[35],
                    'lastname_arab'  => $row[34],
                    'cin'            => trim($row[1]),
                    'ppr'            => $ppr,
                    'local_id'       => $local ? $local->id : null,
                    'birth_date'     => $this->transformDate($row[4]),
                    'birth_city'     => $row[6],
                    'gender'         => $row[8],
                    'sit'            => $row[10],
                    'hiring_date'    => $this->transformDate($row[16]),
                    'address'        => $row[29],
                    'tel'            => $row[30],
                    'email'          => $row[31],
                    'commission_card' => $row[24],
                    'status'         => Employee::STATUS_ACTIVE,
                    'category_id'    => 1,
                ];

                // Category logic
                if (!empty($row[17])) {
                    $employeeData['category_id'] = 2;
                    $employeeData['disposition_date'] = $this->transformDate($row[17]);
                }
                if (!empty($row[18])) {
                    $employeeData['category_id'] = 3;
                    $employeeData['reintegration_date'] = $this->transformDate($row[18]);
                }

                // 3. Process Employee (Create or Update)
                $employee = $this->employeeService->getOneByPPR($ppr);
                if ($employee) {
                    $this->employeeService->update($employee->id, $employeeData);
                    $employeeId = $employee->id;
                } else {
                    $this->employeeService->create($employeeData);
                    $employeeId = $this->employeeService->getLatestInserted()->id;
                }

                // 4. Process Affectation (ONLY if service exists)
                /*
                if ($service) {
                    $targetEntityId = $sector ? $sector->entity_id : ($section ? $section->entity_id : ($entity ? $entity->id : null));

                    $affectationData = [
                        'employee_id' => $employeeId,
                        'service_id'  => $service->id, // We know it's not null here
                        'entity_id'   => $targetEntityId,
                        'sector_id'   => $sector ? $sector->id : null,
                        'section_id'  => $section ? $section->id : null,
                    ];

                    $existingAffectation = $this->affectationService->getOneByEmployeeId($employeeId);
                    if ($existingAffectation) {
                        $this->affectationService->update($existingAffectation->id, $affectationData);
                    } else {
                        $this->affectationService->create($affectationData);
                    }
                }
                */

                // 5. Process Work (Occupation)
                if ($occupation) {
                    $workData = ['employee_id' => $employeeId, 'occupation_id' => $occupation->id];
                    $existingWork = $this->workService->getOneByEmployeeId($employeeId);
                    $existingWork ? $this->workService->update($existingWork->id, $workData) : $this->workService->create($workData);
                }

                // 6. Process Competence (Grade/Level)
                if ($grade) {
                    $parts = explode(" ", $grade->title);
                    $level_title = (count($parts) >= 3) ? strtoupper($parts[0] . " " . $parts[1]) : strtoupper($parts[0]);

                    $space_count = substr_count($grade->title, ' ');
                    $parts = explode(" ", $grade->title);
                    $level_title = "";
                    if ($space_count > 2) {
                        $level_title = strtoupper($parts[0]);
                    } elseif ($space_count == 1) {
                        $level_title = strtoupper($parts[0] . " " . $parts[1]);
                    } else {
                        $level_title = strtoupper($grade->title);
                    }

                    $level = $this->levelService->getOneByTitle($level_title);

                    if ($level) {
                        $compData = ['employee_id' => $employeeId, 'grade_id' => $grade->id, 'level_id' => $level->id];
                        $existingComp = $this->competenceService->getOneByEmployeeId($employeeId);
                        $existingComp ? $this->competenceService->update($existingComp->id, $compData) : $this->competenceService->create($compData);
                    }
                }

                // 7. Process Qualification (Diploma)
                if ($diploma && $option) {
                    $qualData = ['employee_id' => $employeeId, 'diploma_id' => $diploma->id, 'option_id' => $option->id];
                    $existingQual = $this->qualificationService->getOneByEmployeeId($employeeId);
                    $existingQual ? $this->qualificationService->update($existingQual->id, $qualData) : $this->qualificationService->create($qualData);
                }

                $importedCount++;
            }

            DB::commit();
            return redirect()->route('employees.index')->with('success', "Importation réussie : $importedCount/$totalRows agents.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employees.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    private function transformDate($value)
    {
        // 1. Check if the value is actually empty or null
        if (empty($value) || trim($value) === "" || $value == "0") {
            return null;
        }

        try {
            // 2. Handle Excel Numeric Dates (e.g., 44197)
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // 3. Handle String Dates (e.g., "2024-05-15" or "15/05/2024")
            // Use Carbon::parse or createFromFormat if the format is consistent
            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {
            // 4. Return null if parsing fails entirely to avoid 1970 errors
            return null;
        }
    }

    public function import_execute(Request $request) {

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
                    return redirect()->route('employees.index')->with('error', "Agent sont ajouté " . $count . "/" . count($rows[0]) . " !");
                }

            } else {
                return redirect()->route('employees.import')->with('error', "Merci de spécifier le fichier excel contenant les employés");
            }


        } catch (\Exception $exception) {
            Log::error('Error in EmployeeController@importation: ' . $exception->getMessage());
            return back()->with('error', 'Une erreur est survenue.' . $exception->getMessage());
        }
    }

    public function advance(Request $request) {
        try {

            $locals = $this->localService->getAll(0);
            $cities = $this->cityService->getAll(0);
            $services = $this->serviceEntityService->getAll(0);
            $entities = $this->entityService->getAll(0);
            $sectors = $this->sectorEntityService->getAll(0);
            $sections = $this->sectionEntityService->getAll(0);

            return view('app.employees.search', [
                'locals' => $locals,
                'cities' => $cities,
                'services' => $services,
                'entities' => $entities,
                'sectors' => $sectors,
                'sections' => $sections
            ]);


        }catch (\Exception $exception) {

        }
    }

    public function result(Request $request) {
        try {

            $filter['services'] = $request->services;
            $filter['entities'] = $request->entities;
            $filter['sectors'] = $request->sectors;
            $filter['sections'] = $request->sections;
            $filter['cities'] = $request->cities;
            $filter['locals'] = $request->locals;
            $employees = $this->employeeService->getAllByAdvanceFilter($filter, 0);


            if ($request->ajax()) {
                return view('app.employees.search-result', compact('employees'))->render();
            }

        }catch (\Exception $exception) {

        }
    }

    public function state(Request $request) {
        try {
            $employee_id = $request->input('employee_id');
            $employee = $this->employeeService->getOneById($employee_id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $state = $request->input('state');
            $motif = $request->input('motif');
            $date_operation = $request->input('date');

            $result = null;
            switch ($state) {
                case 1:
                    $result = $this->employeeService->changeStateMode($employee_id, $state);
                    break;
                case 0:
                    $data['disposition_date'] = $date_operation;
                    $data['disposition_reason'] = $motif;
                    $data['state'] = $state;
                    $result = $this->employeeService->putOutsideMode($employee_id, $data);
                    break;
                case -1:
                    $data['retiring_date'] = $date_operation;
                    $data['state'] = $state;
                    $result = $this->employeeService->putInRetiredMode($employee_id, $data);
                    break;
                case -2:
                    $data['retiring_date'] = $date_operation;
                    $data['disposition_reason'] = $motif; // use disposition_reason as motif for this state
                    $data['state'] = $state;
                    $result = $this->employeeService->putInSuspensionMode($employee_id, $data);
                    break;
                case 2:
                    $data['reintegration_date'] = $date_operation;
                    $data['reintegration_reason'] = $motif; // use disposition_reason as motif for this state
                    $data['state'] = $state;
                    $result = $this->employeeService->putInReIntegrationMode($employee_id, $data);
                    break;
            }

            if ($result)
                return back()->with('success', "Sitation est bien modifié");
            else
                return back()->with('error', "Erreur lors de la modification de la situation !!");


        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public  function status(Request $request) {
        try {

            $this->pages = $this->setEmployeeCardSession($request);

            $employees = $this->employeeService->getInActiveEmployees($this->pages);
            $male_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'M'], 0);
            $female_employees = $this->employeeService->getAllByFilter(['col' => 'gender', 'val' => 'F'], 0);

            $filter_val = null;
            if ($request->has('flt')) {
                $filter_val = $request->query('flt');
                $employees = $this->employeeService->getAllByFilterValueInactive($filter_val, $this->pages);
            }


            $state = null;
            if ($request->has('state')) {
                $state = $request->query('state');
                $filter['col'] = 'status';
                $filter['val'] = $state;
                $employees = $this->employeeService->allByFilterInActive($filter, $this->pages);
            }

            $employeeObj = null;
            if ($request->has('emp')) {
                $employee_id = $request->query('emp');
                $employeeObj = $this->employeeService->getOneById($employee_id);
            }

            $template = 'app.employees.status';

            return view($template, [
                'employees' => $employees,
                'femaleCount' => $female_employees->count(),
                'maleCount' => $male_employees->count(),
                'total_employee' => $this->pages == 0 ? $employees->count() : $employees->total(),
                'filter_val' => $filter_val,
                'state' => $state,
                'employeeObj' => $employeeObj
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function sort(Request $request)
    {

        $this->pages = $this->setEmployeeCardSession($request);

        $locals = $this->localService->getAll(0);
        $employees = $this->employeeService->sortEmployeesByOption($request, $this->pages);
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

    public function work_certificate($id) {
        try {

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $grade = is_null($employee->competences->where('finished_date', null)->first()) ? 'N/A' : $employee->competences->where('finished_date', null)->first()->grade->title;
            $civility = $employee->gender == 'M' ? 'M' : 'Mme';

            $pdf = Pdf::loadView('app.employees.certificates.work-certificate', [
                'employee' => $employee,
                'grade' => $grade ?? 'N/A',
                'civility' => $civility,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream();

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function bonus_certificate($id) {
        try {

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $grade = is_null($employee->competences->where('finished_date', null)->first()) ? 'N/A' : $employee->competences->where('finished_date', null)->first()->grade->title;
            $civility = $employee->gender == 'M' ? 'M' : 'Mme';

            $pdf = Pdf::loadView('app.employees.certificates.bonus-certificate', [
                'employee' => $employee,
                'grade' => $grade,
                'civility' => $civility,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream();

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function holiday_certificate($id) {
        try {

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $grade = is_null($employee->competences->where('finished_date', null)->first()) ? 'N/A' : $employee->competences->where('finished_date', null)->first()->grade->title;
            $civility = $employee->gender == 'M' ? 'M' : 'Mme';

            $pdf = Pdf::loadView('app.employees.certificates.holiday-certificate', [
                'employee' => $employee,
                'grade' => $grade,
                'civility' => $civility,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream();

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function renewal_certificate($id) {
        try {

            $employee = $this->employeeService->getOneById($id);
            if (is_null($employee))
                return back()->with('error', 'Agent introuvable !!');

            $grade = $employee->competences->where('finished_date', null)->first()->grade->title;
            $civility = $employee->gender == 'M' ? 'M' : 'Mme';

            $pdf = Pdf::loadView('app.employees.certificates.renewal-certificate', [
                'employee' => $employee,
                'grade' => $grade,
                'civility' => $civility,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream();

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


}


