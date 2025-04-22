<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function index()
    {
        return view('Auth.signup');
    }
    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'comfirm_password' => 'required|same:password',
        ]);

        // Handle failed validation
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // repopulate old input values
        }

        // Save to database
        User::create([
            'fullname' => $req->full_name,
            'level' => 'user',
            'username' => $req->full_name,
            'email' => $req->email,
            'password' => Hash::make($req->password), // Always hash passwords!
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Hãy đăng nhập.');
    }
}
