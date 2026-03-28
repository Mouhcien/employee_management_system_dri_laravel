<?php

namespace App\Http\Controllers;

use App\services\ProfileService;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private UserService $userService;
    private ProfileService $profileService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService, ProfileService $profileService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
    }


    public function create() {
        try {

            $profiles = $this->profileService->getAll(0);

            return view('app.users.insert', [
                'profiles' => $profiles,
                'user' => null
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id) {
        try {

            $user = $this->userService->getOneById($id);
            if (is_null($user)) {
                return back()->with('error', 'Utilisateur introuvable !!');
            }

            $profiles = $this->profileService->getAll(0);

            return view('app.users.insert', [
                'profiles' => $profiles,
                'user' => $user
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $user = $this->userService->getOneById($id);
            if (is_null($user)) {
                return back()->with('error', 'Utilisateur introuvable !!');
            }

            $data['name'] = explode("@", $request->email)[0];
            $data['email'] = $request->email;
            $data['profile_id'] = $request->profile_id;

            if (!is_null($request->password) && !is_null($request->password_confirmation)) {
                if ($request->password != $request->password_confirmation)
                    return back()->with('error', 'Les mots de passe ne sont pas identique !!');

                $data['password'] = Hash::make($request->password);
            }

            $result = $this->userService->update($id, $data);

            if ($result)
                return redirect()->route('profiles.index')->with('success', "Les informations de l'utilisateur sont bien changé !!");
            else
                return back()->with('error', 'Problème lors de la mise à jour !!');

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
