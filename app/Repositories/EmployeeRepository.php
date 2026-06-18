<?php

namespace App\repositories;

use App\Models\Employee;
use function Laravel\Prompts\select;

class EmployeeRepository extends MainRepository
{
    private array $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations', 'local', 'category'];

    public function allByFilter($filter, $pages = 0)
    {

        $query =  Employee::with($this->with)
            ->where($filter['col'], '=', $filter['val'])
            ->where('employees.status', '=', 1)
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterInActive($filter, $pages = 0)
    {

        $query =  Employee::with($this->with)
            ->where($filter['col'], '=', $filter['val'])
            ->where('employees.status', '<>', 1)
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByService($service_id, $pages = 0)
    {
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.service_id', '=', $service_id)
            ->where('affectations.finished_date', '=', null)
            ->where('employees.status', '=', 1)
            ->select('employees.*')
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByEntity($entity_id, $pages = 0)
    {
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.entity_id', '=', $entity_id)
            ->where('affectations.finished_date', '=', null)
            ->where('employees.status', '=', 1)
            ->select('employees.*')
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allBySector($sector_id, $pages = 0)
    {
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.sector_id', '=', $sector_id)
            ->where('affectations.finished_date', '=', null)
            ->where('employees.status', '=', 1)
            ->select('employees.*')
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allBySection($section_id, $pages = 0)
    {
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id')
            ->where('affectations.section_id', '=', $section_id)
            ->where('affectations.finished_date', '=', null)
            ->where('employees.status', '=', 1)
            ->select('employees.*')
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterValue($val, $pages = 0)
    {
        $query = Employee::with($this->with)
            ->when($val, function ($query) use ($val) {
                $query->where(function ($q) use ($val) {
                    $q->where('lastname', 'like', "%{$val}%")
                        ->orWhere('firstname', 'like', "%{$val}%")
                        ->orWhere('email', 'like', "%{$val}%")
                        ->orWhere('cin', 'like', "%{$val}%")
                        ->orWhere('ppr', 'like', "%{$val}%")
                        ->orWhere('birth_date', 'like', "%{$val}%")
                        ->orWhere('birth_city', 'like', "%{$val}%")
                        ->orWhere('hiring_date', 'like', "%{$val}%")
                        ->orWhere('tel', 'like', "%{$val}%");
                });
            });

        $query->where('employees.status', '=', 1);
        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterValueInactive($val, $pages = 0)
    {
        $query = Employee::with($this->with)
            ->when($val, function ($query) use ($val) {
                $query->where(function ($q) use ($val) {
                    $q->where('lastname', 'like', "%{$val}%")
                        ->orWhere('firstname', 'like', "%{$val}%")
                        ->orWhere('email', 'like', "%{$val}%")
                        ->orWhere('cin', 'like', "%{$val}%")
                        ->orWhere('ppr', 'like', "%{$val}%")
                        ->orWhere('birth_date', 'like', "%{$val}%")
                        ->orWhere('birth_city', 'like', "%{$val}%")
                        ->orWhere('hiring_date', 'like', "%{$val}%")
                        ->orWhere('tel', 'like', "%{$val}%");
                });
            });

        $query->where('employees.status', '<>', 1);
        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allByFilterAdvanced($filter, $pages = 0)
    {
        $query =  Employee::with($this->with);

        if (isset($filter['filter_value'])) {
            $val = $filter['filter_value'];
            $query->when($val, function ($query) use ($val) {
                $query->where(function ($q) use ($val) {
                    $q->where('lastname', 'like', "%{$val}%")
                        ->orWhere('firstname', 'like', "%{$val}%")
                        ->orWhere('email', 'like', "%{$val}%")
                        ->orWhere('cin', 'like', "%{$val}%")
                        ->orWhere('ppr', 'like', "%{$val}%")
                        ->orWhere('birth_date', 'like', "%{$val}%")
                        ->orWhere('birth_city', 'like', "%{$val}%")
                        ->orWhere('hiring_date', 'like', "%{$val}%")
                        ->orWhere('tel', 'like', "%{$val}%");
                });
            });
        }

        if (isset($filter['local_id']) && $filter['local_id'] != '-1')
            $query->where('employees.local_id', '=', $filter['local_id']);

        if (isset($filter['city_id']) && $filter['city_id'] != '-1') {
            $query->join('locals', 'locals.id', '=', 'employees.local_id');
            $query->where('locals.city_id', '=', $filter['city_id']);
        }

        if (isset($filter['gender']))
            $query->where('gender', '=', $filter['gender']);

        $query->where('employees.status', '=', 1);
        $query->select('employees.*');
        $query->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function getAllByAdvanceFilter($filter, $pages){
        $query =  Employee::with($this->with)
            ->join('affectations', 'affectations.employee_id', '=', 'employees.id');

        if (isset($filter['services']))
            $query->whereIn('affectations.service_id', $filter['services']);

        if (isset($filter['entities']))
            $query->whereIn('affectations.entity_id', $filter['entities']);

        if (isset($filter['sectors']))
            $query->whereIn('affectations.sector_id', $filter['sectors']);

        if (isset($filter['sections']))
            $query->whereIn('affectations.section_id', $filter['sections']);

        if (isset($filter['locals']))
            $query->whereIn('local_id', $filter['locals']);

        if (isset($filter['cities'])) {
            $query->join('locals', 'locals.id', '=', 'employees.local_id');
            $query->whereIn('locals.city_id', $filter['cities']);
        }

        if (isset($filter['gender']))
            $query->where('gender', '=', $filter['gender']);

        $query->where('affectations.state', '=', '1');
        $query->select('employees.*');
        $query->orderBy('employees.lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }


    public function getOneByPPR($ppr) {
        return Employee::with($this->with)
            ->where('ppr', '=', $ppr)
            ->first();
    }

    public function getOneByEmail($email) {
        return Employee::with($this->with)
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->first();
    }

    public function allByCategory($category_id, $with, $pages) {
        $query =  Employee::with($with)
            ->where('category_id', '=', $category_id)
            ->where('employees.status', '=', 1)
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allTotalByCategory() {
        return Employee::query()
            ->join('categories', 'categories.id', '=', 'employees.category_id')
            ->selectRaw('employees.category_id, categories.title, COUNT(employees.id) AS total')
            ->groupBy('employees.category_id', 'categories.title')
            ->where('employees.status', '=', 1)
            ->get();
    }

    public function allExternEmployees($pages) {
        $query =  Employee::with($this->with)
            ->whereIn('employees.category_id', [2, 3])
            ->where('employees.status', '=', 1)
            ->orderBy('lastname', 'ASC');


        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function allTotalByLocal() {
        return Employee::query()
            ->join('locals', 'locals.id', '=', 'employees.local_id')
            ->selectRaw('employees.local_id, locals.title, COUNT(employees.id) AS total')
            ->groupBy('employees.local_id', 'locals.title')
            ->where('employees.status', '=', 1)
            ->get();
    }


    public function inActiveEmployees($with, $pages) {
        $query =  Employee::with($with)
            ->where('employees.status', '<>', 1)
            ->orderBy('lastname', 'ASC');

        return $pages == 0 ? $query->get() : $query->paginate($pages);
    }

    public function AllEmployeeWithoutAffectation($with) {
        return Employee::with($with)
            ->whereNotIn('employees.id', function($query) {
                $query->select('affectations.employee_id')->from('affectations');
            })
            ->where('employees.status', '=', '1')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function AllEmployeeWithoutGrade($with) {
        return Employee::with($with)
            ->whereNotIn('employees.id', function($query) {
                $query->select('competences.employee_id')->from('competences');
            })
            ->where('employees.status', '=', '1')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function AllEmployeeWithoutDiploma($with) {
        return Employee::with($with)
            ->whereNotIn('employees.id', function($query) {
                $query->select('qualifications.employee_id')->from('qualifications');
            })
            ->where('employees.status', '=', '1')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    /**
     * Récupérer les doublons par PPR
     */
    public function AllDuplicatePPR($with) {
        $duplicates = Employee::where('status', 1)
            ->whereNotNull('ppr')
            ->where('ppr', '!=', '')
            ->groupBy('ppr')
            ->havingRaw('COUNT(ppr) > 1')
            ->pluck('ppr');

        return Employee::with($with)
            ->whereIn('ppr', $duplicates)
            ->where('status', 1)
            ->orderBy('ppr', 'ASC')
            ->get()
            ->groupBy('ppr');
    }

    /**
     * Récupérer les doublons par CIN
     */
    public function AllDuplicateCIN($with) {
        $duplicates = Employee::where('status', 1)
            ->whereNotNull('cin')
            ->where('cin', '!=', '')
            ->groupBy('cin')
            ->havingRaw('COUNT(cin) > 1')
            ->pluck('cin');

        return Employee::with($with)
            ->whereIn('cin', $duplicates)
            ->where('status', 1)
            ->orderBy('cin', 'ASC')
            ->get()
            ->groupBy('cin');
    }

    /**
     * Récupérer les doublons par Email
     */
    public function AllDuplicateEmail($with) {
        $duplicates = Employee::where('status', 1)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->groupBy('email')
            ->havingRaw('COUNT(email) > 1')
            ->pluck('email');

        return Employee::with($with)
            ->whereIn('email', $duplicates)
            ->where('status', 1)
            ->orderBy('email', 'ASC')
            ->get()
            ->groupBy('email');
    }

    /**
     * Récupérer les doublons par Carte Commission
     */
    public function AllDuplicateCommissionCard($with) {
        $duplicates = Employee::where('status', 1)
            ->whereNotNull('commission_card')
            ->where('commission_card', '!=', '')
            ->groupBy('commission_card')
            ->havingRaw('COUNT(commission_card) > 1')
            ->pluck('commission_card');

        return Employee::with($with)
            ->whereIn('commission_card', $duplicates)
            ->where('status', 1)
            ->orderBy('commission_card', 'ASC')
            ->get()
            ->groupBy('commission_card');
    }

    public function AllEmployeeWithoutPPR($with) {
        return Employee::with($with)
            ->where('employees.status', '=', 1)
            ->whereNull('employees.ppr')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function AllEmployeeWithoutCIN($with) {
        return Employee::with($with)
            ->where('employees.status', '=', 1)
            ->whereNull('employees.cin')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function AllEmployeeWithoutEmail($with) {
        return Employee::with($with)
            ->where('employees.status', '=', 1)
            ->whereNull('employees.email')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function AllEmployeeWithoutCommissionCard($with) {
        return Employee::with($with)
            ->where('employees.status', '=', 1)
            ->whereNull('employees.commission_card')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function sortEmployeesByOption($request, $pages) {

        $query = Employee::with(['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'])
                ->where('employees.status', '=', '1');

        // 1. Tri par PPR
        if ($request->filled('sort_ppr')) {
            $query->orderBy('ppr', $request->sort_ppr);
        }

        // 2. Tri par Nom
        if ($request->filled('sort_lastname')) {
            $query->orderBy('lastname', $request->sort_lastname);
        }

        // 3. Tri par Prénom
        if ($request->filled('sort_firstname')) {
            $query->orderBy('firstname', $request->sort_firstname);
        }

        // 4. Tri par Âge (Logique inverse sur birth_date)
        if ($request->filled('sort_age')) {
            // asc = plus jeune (date de naissance la plus récente/grande)
            // desc = plus âgé (date de naissance la plus ancienne/petite)
            $direction = ($request->sort_age === 'asc') ? 'desc' : 'asc';
            $query->orderBy('birth_date', $direction);
        }

        // Tri par défaut si rien n'est sélectionné
        if (!$request->hasAny(['sort_ppr', 'sort_lastname', 'sort_firstname', 'sort_age'])) {
            $query->orderBy('lastname', 'asc');
        }

        return $query->paginate($pages)->withQueryString();

    }

}
