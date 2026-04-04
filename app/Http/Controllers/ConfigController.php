<?php

namespace App\Http\Controllers;

use App\services\ConfigService;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    private ConfigService $configService;
    private $rules = [
        'value' => 'required'
    ];

    /**
     * @param ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function index() {
        try {

            $configs = $this->configService->getAllByUser(auth()->user()->id, 0);

            return view('app.configs.index', [
                'configs' => $configs
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {

            $config = $this->configService->getOneById($id);
            if (is_null($config))
                return back()->with('error', 'Paramètre introuvable');

            $data = $request->validate($this->rules);
            $data['user_id'] = auth()->user()->id;
            $result = $this->configService->update($id, $data);

            if ($result){
                $configs = $this->configService->getAllByUser(auth()->user()->id, 0);
                session()->put('configs', $configs);
                return redirect()->route('configs.index')->with('success', 'Mise à jour bien faite !!!');
            } else
                return back()->with('error', 'Erreur lor de la mise à jour bien faite !!!');

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
