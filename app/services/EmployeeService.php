<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll(int $pages = 0)
    {
        $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'];

        return $this->employeeRepository->all(Employee::class, $with, $pages);
    }

    public function getOneById(int $id): ?Employee
    {
        $with = ['works', 'qualifications', 'competences', 'remunerations', 'chefs', 'affectations'];

        return $this->employeeRepository->one(Employee::class, $with, $id);
    }

    public function create(array $data): ?bool
    {
        $employee = new Employee();
        $employee->fill($this->filterData($data));

        return $this->employeeRepository->add($employee);
    }

    public function update(int $id, array $data): ?bool
    {
        $employee = $this->getOneById($id);

        if (! $employee) {
            return null;
        }

        $employee->fill($this->filterData($data));

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
            'status'
        ])->toArray();
    }
}
