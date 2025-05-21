<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        Auth::logout(); // Đăng xuất user

        $request->session()->invalidate(); // Xóa session cũ
        $request->session()->regenerateToken(); // Tạo CSRF token mới

        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }
}
