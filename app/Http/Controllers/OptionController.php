<?php

namespace App\Http\Controllers;

use App\services\OptionService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    private OptionService $optionService;
    private $pages = 10;

    /**
     * @param OptionService $optionService
     */
    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
    }

    public function index() {
        try {
            $options = $this->optionService->getAll($this->pages);

            return view('app.education.options.index', [
                'options' => $options
            ]);
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
