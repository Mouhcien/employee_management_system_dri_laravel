<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\EmployeeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private EmployeeService $employeeService;

    /**
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        $employee = $this->employeeService->getOneByEmail($user->email);

        if (is_null($employee)) {
            return redirect()->route('login')->with('error', 'Agent Introuvable');
        }

        $photoUrl = ($employee->photo && Storage::disk('public')->exists($employee->photo))
            ? $employee->photo
            : asset('images/default-avatar.png');

        session([
            'employee_id'    => $employee->id,
            'employee_name'  => $employee->firstname . ' ' . $employee->lastname,
            'employee_photo' => $photoUrl,
        ]);

        return redirect()->intended(route('dashboard0', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
