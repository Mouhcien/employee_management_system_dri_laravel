<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\services\ConfigService;
use App\Services\EmployeeService;
use App\services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private ConfigService $configService;
    private EmployeeService $employeeService;
    private UserService $userService;

    /**
     * @param ConfigService $configService
     */
    public function __construct(ConfigService $configService, EmployeeService $employeeService, UserService $userService)
    {
        $this->configService = $configService;
        $this->employeeService = $employeeService;
        $this->userService = $userService;
    }


    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_id' => 'required'
        ]);

        $username = explode('@', $request->email);

        $existedUser = $this->userService->getOneByUsername($username[0]);

        if (!is_null($existedUser))
            return back()->with('error', "Utilisateur déja existe !!!");

        $user = User::create([
            'name' => $username[0],
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_id' => $request->profile_id
        ]);

        event(new Registered($user));

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

        $data['user_id'] = $user->id;
        $data['title'] = 'Navigation';
        $data['value'] = 'Vertical';
        $resultConfig = $this->configService->create($data);

        if ($resultConfig) {
            $configs = $this->configService->getAllByUser($user->id, 0);
            session()->put('configs', $configs);
        }

        Auth::login($user);

        return redirect(route('dashboard0', absolute: false));
    }
}
