<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function index(){
        $employee = Auth::user();
        return view('profile.index',compact('employee'));
    }
}
