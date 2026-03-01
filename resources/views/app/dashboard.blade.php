{{-- resources/views/dashboard.blade.php --}}
{{-- @extends('layouts.app') --}}

<x-layout>
    @section('title', 'Dashboard - HR Management')

    <div class="mb-5">
            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">Dashboard</h1>
                <span class="text-muted">{{ now()->format('l, F j, Y') }}</span>
            </div>

            {{-- Metrics Cards --}}
            <div class="row g-4 mb-5">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="card-text small text-muted mb-1">Total Employees</p>
                                    <p class="h3 mb-0 fw-bold">{{ $totalEmployees ?? 142 }}</p>
                                </div>
                                <div class="ms-auto p-3 bg-primary-subtle rounded-circle">
                                    <i class="bi bi-people-fill text-primary fs-4"></i>
                                </div>
                            </div>
                            <p class="text-success small mb-0 d-flex align-items-center">
                                <i class="bi bi-arrow-up me-1"></i>
                                +5 this month
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="card-text small text-muted mb-1">Present Today</p>
                                    <p class="h3 mb-0 fw-bold">{{ $presentToday ?? 128 }}</p>
                                </div>
                                <div class="ms-auto p-3 bg-success-subtle rounded-circle">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">90% attendance rate</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="card-text small text-muted mb-1">On Leave</p>
                                    <p class="h3 mb-0 fw-bold">{{ $onLeave ?? 12 }}</p>
                                </div>
                                <div class="ms-auto p-3 bg-warning-subtle rounded-circle">
                                    <i class="bi bi-clock-fill text-warning fs-4"></i>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">8 pending approvals</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="card-text small text-muted mb-1">New Hires</p>
                                    <p class="h3 mb-0 fw-bold">{{ $newHires ?? 5 }}</p>
                                </div>
                                <div class="ms-auto p-3 bg-info-subtle rounded-circle">
                                    <i class="bi bi-person-plus-fill text-info fs-4"></i>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">This month</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions & Recent Activity --}}
            <div class="row g-4 mb-5">
                {{-- Quick Actions --}}
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h2 class="h5 mb-0">Quick Actions</h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <a href="{{ route('employees.create') }}" class="card border h-100 text-decoration-none text-reset hover-border-primary hover-bg-primary-subtle">
                                        <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                            <div class="p-3 bg-primary-subtle rounded-circle mb-3">
                                                <i class="bi bi-person-plus text-primary fs-4"></i>
                                            </div>
                                            <span class="fw-semibold">Add Employee</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3">
                                    <a href="#" class="card border h-100 text-decoration-none text-reset hover-border-success hover-bg-success-subtle">
                                        <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                            <div class="p-3 bg-success-subtle rounded-circle mb-3">
                                                <i class="bi bi-file-earmark-pdf text-success fs-4"></i>
                                            </div>
                                            <span class="fw-semibold">Generate Report</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3">
                                    <a href="#" class="card border h-100 text-decoration-none text-reset hover-border-warning hover-bg-warning-subtle">
                                        <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                            <div class="p-3 bg-warning-subtle rounded-circle mb-3">
                                                <i class="bi bi-check-circle text-warning fs-4"></i>
                                            </div>
                                            <span class="fw-semibold">Approve Leave</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3">
                                    <a href="#" class="card border h-100 text-decoration-none text-reset hover-border-purple hover-bg-purple-subtle">
                                        <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                            <div class="p-3 bg-purple-subtle rounded-circle mb-3">
                                                <i class="bi bi-download text-purple fs-4"></i>
                                            </div>
                                            <span class="fw-semibold">Export Data</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Department Summary --}}
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h2 class="h5 mb-0">Departments</h2>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-pill me-2">Eng</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="small text-muted">Engineering</span>
                                </div>
                                <span class="fw-semibold">45</span>
                            </div>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success rounded-pill me-2">Sales</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="small text-muted">Sales & Marketing</span>
                                </div>
                                <span class="fw-semibold">32</span>
                            </div>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-warning rounded-pill me-2">Ops</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="small text-muted">Operations</span>
                                </div>
                                <span class="fw-semibold">28</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-danger rounded-pill me-2">HR</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="small text-muted">HR & Finance</span>
                                </div>
                                <span class="fw-semibold">18</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="card">
                <div class="card-header pb-0">
                    <h2 class="h5 mb-0">Recent Activity</h2>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 p-2 bg-success-subtle rounded-circle me-3">
                                <i class="bi bi-person-plus text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 small"><span class="fw-semibold">New hire:</span> Sarah Johnson joined as Senior Developer</p>
                                <p class="mb-0 small text-muted">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 p-2 bg-warning-subtle rounded-circle me-3">
                                <i class="bi bi-clock text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 small"><span class="fw-semibold">Leave approved:</span> Mike Chen's vacation request approved</p>
                                <p class="mb-0 small text-muted">4 hours ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 p-2 bg-info-subtle rounded-circle me-3">
                            <i class="bi bi-pencil-square text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1 small"><span class="fw-semibold">Updated:</span> Emily Davis promoted to Team Lead</p>
                            <p class="mb-0 small text-muted">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layout>
