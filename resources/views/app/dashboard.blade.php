{{-- resources/views/dashboard.blade.php --}}
{{-- @extends('layouts.app') --}}

<x-layout>
    @section('title', 'Dashboard - HR Management')

    @section('content')
        <div class="space-y-6">
            {{-- Page Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
            </div>

            {{-- Metrics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Employees</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalEmployees ?? 142 }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-green-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +5 this month
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Present Today</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $presentToday ?? 128 }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">90% attendance rate</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">On Leave</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $onLeave ?? 12 }}</p>
                        </div>
                        <div class="p-3 bg-amber-100 rounded-full">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">8 pending approvals</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">New Hires</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $newHires ?? 5 }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">This month</p>
                </div>
            </div>

            {{-- Quick Actions & Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Quick Actions --}}
                <div class="lg:col-span-2 bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('employees.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                            <div class="p-3 bg-indigo-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Add Employee</span>
                        </a>
                        <a href="#" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                            <div class="p-3 bg-green-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Generate Report</span>
                        </a>
                        <a href="#" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                            <div class="p-3 bg-amber-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Approve Leave</span>
                        </a>
                        <a href="#" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                            <div class="p-3 bg-purple-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Export Data</span>
                        </a>
                    </div>
                </div>

                {{-- Department Summary --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Departments</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Engineering</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">45</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Sales & Marketing</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">32</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-amber-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Operations</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">28</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-rose-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">HR & Finance</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">18</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-green-100 rounded-full">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900"><span class="font-semibold">New hire:</span> Sarah Johnson joined as Senior Developer</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-amber-100 rounded-full">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900"><span class="font-semibold">Leave approved:</span> Mike Chen's vacation request approved</p>
                                <p class="text-xs text-gray-500">4 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900"><span class="font-semibold">Updated:</span> Emily Davis promoted to Team Lead</p>
                                <p class="text-xs text-gray-500">Yesterday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-layout>

