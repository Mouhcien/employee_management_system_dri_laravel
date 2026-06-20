<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\services\ConfigService;
use App\Services\EmployeeService;
use App\services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private EmployeeService $employeeService;
    private ConfigService $configService;
    private UserService $userService;

    public function __construct(EmployeeService $employeeService, ConfigService $configService, UserService $userService)
    {
        $this->employeeService = $employeeService;
        $this->configService = $configService;
        $this->userService = $userService;
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
    public function store(Request $request): RedirectResponse
    {
        $username = $request->username;
        $password = $request->password;

        $existed_user = $this->userService->getOneByUsername($username);

        if (is_null($existed_user)) {
            return redirect()->route('login')->with('error', 'Utilisateur Introuvable');
        } else {
            if (Hash::check($password, $existed_user->password)) {

                $user = $existed_user;

                $employee = $this->employeeService->getOneByEmail(strtolower($user->email));

                if (is_null($employee)) {
                    return redirect()->route('login')->with('error', 'Agent Introuvable');
                }

                // 1. Log the user into Laravel's Auth System
                Auth::login($user);

                // 2. Regenerate the session immediately AFTER login (Laravel security best practice)
                $request->session()->regenerate();

                $photoUrl = ($employee->photo && Storage::disk('public')->exists($employee->photo))
                    ? $employee->photo
                    : asset('images/default-avatar.png');

                session([
                    'employee_id'    => $employee->id,
                    'employee_name'  => $employee->firstname . ' ' . $employee->lastname,
                    'employee_photo' => $photoUrl,
                ]);

                // Get the Navigation config
                $configs = $this->configService->getAllByUser($user->id, 0);
                session()->put('configs', $configs);

                return redirect()->route('dashboard0');

            } else {
                return redirect()->route('login')->with('error', 'Mot de passe incorrect');
            }

        }

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
