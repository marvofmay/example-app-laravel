<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        //dd(Auth()->user()->createToken('example-app')->plainTextToken);
        return view('index');
    }
}
