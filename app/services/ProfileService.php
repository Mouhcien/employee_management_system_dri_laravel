<?php

namespace App\services;

use App\Models\Profile;
use App\repositories\ProfileRepository;

class ProfileService
{

    private ProfileRepository $profileRepository;
    private $with = ['habilitations'];

    /**
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAll($pages=0){
        return $this->profileRepository->All(Profile::class, $this->with, $pages);
    }

    public function getOneById($id){
        return $this->profileRepository->One(Profile::class, $this->with, $id);
    }

    public function create($data){
        $obj = new Profile();

        $obj->title = $data['title'];

        return $this->profileRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        return $this->profileRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->profileRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->profileRepository->LatestInserted(Profile::class);
    }
}
