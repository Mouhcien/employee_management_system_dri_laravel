<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;
    private $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'];

    public function __construct(
        EmployeeRepository $employeeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll(int $pages = 0)
    {
        return $this->employeeRepository->all(Employee::class, $this->with, $pages);
    }

    public function getAllByFilter($filter, $pages = 0)
    {
        return $this->employeeRepository->allByFilter($filter, $pages);
    }

    public function getAllByFilterValue($val, $pages = 0)
    {
        return $this->employeeRepository->allByFilterValue($val, $pages);
    }

    public function getAllByFilterAdvanced($filter, $pages = 0)
    {
        return $this->employeeRepository->allByFilterAdvanced($filter, $pages);
    }

    public function getOneById(int $id): ?Employee
    {
        return $this->employeeRepository->one(Employee::class, $this->with, $id);
    }

    public function getOneByPPR($ppr) {
        return $this->employeeRepository->getOneByPPR($ppr);
    }

    public function create(array $data): ?bool
    {
        $employee = new Employee();

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
        $employee->city = $data['city'];
        $employee->email = $data['email'];
        $employee->category_id = $data['category_id'];
        $employee->status = $data['status'];

        return $this->employeeRepository->add($employee);
    }

    public function update(int $id, array $data): ?bool
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

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
        $employee->city = $data['city'];
        $employee->email = $data['email'];
        $employee->category_id = $data['category_id'];
        $employee->status = $data['status'];

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

    public function getLatestInserted(): ?Employee
    {
        return $this->employeeRepository->latestInserted(Employee::class);
    }

    private function filterData(array $data): array
    {
        return collect($data)->only([
            'ppr',
            'cin',
            'firstname',
            'lastname',
            'firstname_arab',
            'lastname_arab',
            'birth_date',
            'birth_city',
            'gender',
            'sit',
            'hiring_date',
            'local_id',
            'address',
            'city',
            'tel',
            'email',
            'photo',
            'status',
            'hiring_public_date',
            'category_id'
        ])->toArray();
    }
}
