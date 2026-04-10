<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use function PHPUnit\Framework\isString;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;
    private $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations', 'attendences'];

    public function __construct(
        EmployeeRepository $employeeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll(int $pages = 0)
    {
        return $this->employeeRepository->all(Employee::class, $this->with, $pages);
    }

    public function getInActiveEmployees(int $pages = 0)
    {
        return $this->employeeRepository->inActiveEmployees($this->with, $pages);
    }

    public function getAllByCategory($category_id, $pages = 0)
    {
        return $this->employeeRepository->allByCategory($category_id, $this->with, $pages);
    }

    public function getTotalByCategory()
    {
        return $this->employeeRepository->allTotalByCategory();
    }

    public function getTotalByLocal()
    {
        return $this->employeeRepository->allTotalByLocal();
    }

    public function getAllByFilter($filter, $pages = 0)
    {
        return $this->employeeRepository->allByFilter($filter, $pages);
    }

    public function allByFilterInActive($filter, $pages = 0)
    {
        return $this->employeeRepository->allByFilterInActive($filter, $pages);
    }

    public function getAllByFilterValue($val, $pages = 0)
    {
        return $this->employeeRepository->allByFilterValue($val, $pages);
    }

    public function getAllByFilterValueInactive($val, $pages = 0)
    {
        return $this->employeeRepository->allByFilterValueInactive($val, $pages);
    }

    public function getAllByService($service_id, $pages = 0)
    {
        return $this->employeeRepository->allByService($service_id, $pages);
    }

    public function getAllByEntity($entity_id, $pages = 0)
    {
        return $this->employeeRepository->allByEntity($entity_id, $pages);
    }

    public function getAllBySector($sector_id, $pages = 0)
    {
        return $this->employeeRepository->allBySector($sector_id, $pages);
    }

    public function getAllBySection($section_id, $pages = 0)
    {
        return $this->employeeRepository->allBySection($section_id, $pages);
    }

    public function getAllByFilterAdvanced($filter, $pages = 0)
    {
        return $this->employeeRepository->allByFilterAdvanced($filter, $pages);
    }

    public function getAllByAdvanceFilter($filter, $pages=0){
        return $this->employeeRepository->getAllByAdvanceFilter($filter, $pages);
    }

    public function getOneById(int $id): ?Employee
    {
        return $this->employeeRepository->one(Employee::class, $this->with, $id);
    }


    public function getOneByPPR($ppr) {
        return $this->employeeRepository->getOneByPPR($ppr);
    }
    public function getOneByEmail($email) {
        return $this->employeeRepository->getOneByEmail($email);
    }

    public function create(array $data): ?bool
    {
        $employee = new Employee();

        $employee->ppr = $data['ppr'];
        $employee->cin = $data['cin'];
        $employee->firstname = $data['firstname'];
        $employee->lastname = $data['lastname'];
        $employee->local_id = $data['local_id'];
        $employee->firstname_arab = $data['firstname_arab'];
        $employee->firstname_arab = $data['firstname_arab'];
        $employee->lastname_arab = $data['lastname_arab'];
        $employee->birth_date = $data['birth_date'];
        $employee->birth_city = $data['birth_city'];
        $employee->gender = $data['gender'];
        $employee->sit = $data['sit'];
        $employee->hiring_date = $data['hiring_date'];
        $employee->hiring_public_date = $data['hiring_public_date'];
        $employee->address = $data['address'];
        $employee->tel = $data['tel'];
        $employee->email = $data['email'];
        $employee->category_id = $data['category_id'];
        $employee->status = $data['status'];
        $employee->photo = $data['photo'];
        if (isset($data['commission_card']))
            $employee->commission_card = $data['commission_card'];
        if (isset($data['disposition_date']))
                $employee->disposition_date = $data['disposition_date'];
        if (isset($data['reintegration_date']))
            $employee->reintegration_date = $data['reintegration_date'];

        return $this->employeeRepository->add($employee);
    }

    public function update(int $id, array $data): ?bool
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        if (isset($data['ppr']))
            $employee->ppr = $data['ppr'];
        if (isset($data['cin']))
            $employee->cin = $data['cin'];
        if (isset($data['firstname']))
            $employee->firstname = $data['firstname'];
        if (isset($data['lastname']))
            $employee->lastname = $data['lastname'];
        if (isset($data['local_id']))
            $employee->local_id = $data['local_id'];
        if (isset($data['firstname_arab']))
            $employee->firstname_arab = $data['firstname_arab'];
        if (isset($data['lastname_arab']))
            $employee->lastname_arab = $data['lastname_arab'];
        if (isset($data['birth_date']))
            $employee->birth_date = $data['birth_date'];
        if (isset($data['birth_city']))
            $employee->birth_city = $data['birth_city'];
        if (isset($data['gender']))
            $employee->gender = $data['gender'];
        if (isset($data['sit']))
            $employee->sit = $data['sit'];
        if (isset($data['hiring_date']))
            $employee->hiring_date = $data['hiring_date'];
        if (isset($data['hiring_public_date']))
            $employee->hiring_public_date = $data['hiring_public_date'];
        if (isset($data['address']))
            $employee->address = $data['address'];
        if (isset($data['tel']))
            $employee->tel = $data['tel'];
        if (isset($data['email']))
            $employee->email = $data['email'];
        if (isset($data['category_id']))
            $employee->category_id = $data['category_id'];
        if (isset($data['status']))
            $employee->status = $data['status'];
        if (isset($data['photo']))
            $employee->photo = $data['photo'];
        if (isset($data['commission_card']))
            $employee->commission_card = $data['commission_card'];
        if (isset($data['disposition_date']))
            $employee->disposition_date = $data['disposition_date'];
        if (isset($data['reintegration_date']))
            $employee->reintegration_date = $data['reintegration_date'];

        return $this->employeeRepository->update($employee);
    }

    public function changeStateMode($id, $state)
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->status = $state;

        return $this->employeeRepository->update($employee);
    }

    public function putOutsideMode($id, $data)
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->disposition_date = $data['disposition_date'];
        $employee->disposition_reason = $data['disposition_reason'];
        $employee->status = $data['state'];

        return $this->employeeRepository->update($employee);
    }

    public function putInRetiredMode($id, $data)
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->retiring_date = $data['retiring_date'];
        $employee->status = $data['state'];

        return $this->employeeRepository->update($employee);
    }

    public function putInSuspensionMode($id, $data)
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->retiring_date = $data['retiring_date'];
        $employee->disposition_reason = $data['disposition_reason'];
        $employee->status = $data['state'];

        return $this->employeeRepository->update($employee);
    }

    public function putInReIntegrationMode($id, $data)
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->reintegration_date = $data['reintegration_date'];
        $employee->reintegration_reason = $data['reintegration_reason'];
        $employee->status = $data['state'];

        return $this->employeeRepository->update($employee);
    }

    public function delete(int $id): ?bool
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        return $this->employeeRepository->delete($employee);
    }

    public function getLatestInserted()
    {
        return $this->employeeRepository->latestInserted(Employee::class);
    }

    public function sortEmployeesByOption($params, $pages) {
        return $this->employeeRepository->sortEmployeesByOption($params, $pages);
    }

}
