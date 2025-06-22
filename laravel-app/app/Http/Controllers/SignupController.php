<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
                ->withInput();
        }

        $plan = Plan::where('price', 0)->first();


        $user = User::create([
            'fullname' => $req->full_name,
            'level' => 'user',
            'username' => $req->full_name,
            'email' => $req->email,
            'available_question' => $plan->questions_limit,
            'password' => Hash::make($req->password),
        ]);

        UserPlan::create([
            'id_user' => $user->id,
            'id_plan' => $plan->id,
            'start_date' => Carbon::now(),
            'end_date' => null,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Hãy đăng nhập.');
    }
}
