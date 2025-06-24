<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect('/')->with('success', 'Đăng nhập thành công!');
            } else {
                // Tạo người dùng mới với thông tin từ Google
                return view('auth.register_with_google', ['googleUser' => $googleUser]);
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập thất bại, vui lòng thử lại.');
        }
    }
    public function registerWithGoogle(Request $request)
    {
        // Validate mật khẩu
        $validated = $request->validate([
            'password' => 'required|confirmed',
        ]);
        $plan = Plan::where('price', 0)->first();

        // Tạo người dùng mới với Google thông tin và mật khẩu
        $user = User::create([
            'fullname' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'available_question' => $plan->questions_limit,
            'password' => Hash::make($request->password),
            'level' => 'user'
        ]);
        UserPlan::create([
            'id_user' => $user->id,
            'id_plan' => $plan->id,
            'start_date' => Carbon::now(),
            'end_date' => null,
        ]);


        // Đăng nhập người dùng và chuyển hướng đến dashboard
        Auth::login($user);
        return redirect('/')->with('success', 'Tạo tài khoản thành công và đăng nhập!');
    }
}
