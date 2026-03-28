<?php

namespace App\services;

use App\Models\User;
use App\repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private $with = ['profile'];

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll($pages=0){
        return $this->userRepository->All(User::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->userRepository->One(User::class, $this->with, $id);
    }

    public function create($data){
        $obj = new User();

        $obj->name = $data['email'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];
        $obj->profile_id = $data['profile_id'];

        return $this->userRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;


        if (isset($data['name']))
            $obj->name = $data['name'];
        if (isset($data['email']))
            $obj->email = $data['email'];
        if (isset($data['password']))
            $obj->password = $data['password'];
        if (isset($data['profile_id']))
            $obj->profile_id = $data['profile_id'];

        return $this->userRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->userRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->userRepository->LatestInserted(User::class);
    }

}
