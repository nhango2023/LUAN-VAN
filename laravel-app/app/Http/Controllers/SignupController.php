<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }
    public function store(Request $req)
    {
        dd($req->input());
    }
}
