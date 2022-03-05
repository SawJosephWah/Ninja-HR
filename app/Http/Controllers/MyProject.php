<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyProject extends Controller
{
    public function index()
    {
        return view('MyProject.index');
    }
}
