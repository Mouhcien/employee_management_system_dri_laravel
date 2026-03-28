<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\services\ProfileService;
use App\services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mockery\Exception;

class ProfileController extends Controller
{

    private ProfileService $profileService;
    private UserService $userService;
    private $pages = 0;

    /**
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService, UserService $userService)
    {
        $this->profileService = $profileService;
        $this->userService = $userService;
    }

    public function index() {
        try {

            $users = $this->userService->getAll($this->pages);

            return view('app.profiles.index', [
                'users' => $users
            ]);

        }catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function show($id) {
        try {

            $profile = $this->profileService->getOneById($id);
            if (is_null($profile)) {
                return back()->with('error', 'Profil introuvable !!');
            }

            return view('app.profiles.show', [
                'profile' => $profile
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
