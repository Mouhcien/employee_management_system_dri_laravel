<?php

namespace App\services;

use App\Models\Config;
use App\repositories\ConfigRepository;

class ConfigService
{
    private ConfigRepository $configRepository;

    /**
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function getAll($pages=0){
        return $this->configRepository->All(Config::class, [], $pages);
    }

    public function getOneById($id){
        return $this->configRepository->One(Config::class, [], $id);
    }

    public function create($data){
        $obj = new Config();

        $obj->title = $data['title'];
        $obj->value = $data['value'];

        return $this->configRepository->Add($obj);
    }

    public function update($id, $data){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        if (isset($data['title']))
            $obj->title = $data['title'];

        if (isset($data['value']))
            $obj->value = $data['value'];

        return $this->configRepository->Update($obj);
    }
    public function delete($id){
        $obj = $this->getOneById($id);
        if (is_null($obj))
            return null;

        return $this->configRepository->Delete($obj);
    }

    public function getLatestInserted(){
        return $this->configRepository->LatestInserted(Config::class);
    }
}
