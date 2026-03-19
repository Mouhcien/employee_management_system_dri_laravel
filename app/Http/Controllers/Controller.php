<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

abstract class Controller
{

    public function setEmployeeCardSession(Request $request) {
        $pages = 0;
        if ($request->has('opt')) {
            if ($request->query('opt') == 'list') {
                $pages = 10;
                $request->session()->put('opt', 'list');
            } elseif ($request->query('opt') == 'cards') {
                $pages = 12;
                $request->session()->put('opt', 'cards');
            }elseif ($request->query('opt') == 'empcrd') {
                $request->session()->put('opt', 'empcrd');
            }
        } else {
            if ($request->session()->has('opt')) {
                if ($request->session()->get('opt') == 'list') {
                    $pages = 10;
                    $request->session()->put('opt', 'list');
                }elseif ($request->session()->get('opt') == 'cards') {
                    $pages = 12;
                    $request->session()->put('opt', 'cards');
                }elseif ($request->session()->get('opt') == 'empcrd') {
                    $request->session()->put('opt', 'empcrd');
                }
            }
        }
        return $pages;
    }
}
