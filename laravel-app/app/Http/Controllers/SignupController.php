<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }
    public function store(Request $req)
    {
        // Kiểm tra xác nhận mật khẩu
        if ($req->input('password') !== $req->input('comfirm_password')) {
            return back()->with('error', 'Mật khẩu xác nhận không khớp.')->withInput();
        }

        // Tạo user mới

        $user = new User();
        $user->fullname = $req->input('full_name');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->username = $req->input('email'); // Có thể dùng email làm username nếu muốn
        $user->level = 'user'; // hoặc 'admin' tùy hệ thống
        $user->status = '1'; // trạng thái mặc định là hoạt động

        $user->save();

        return back()->with('success', 'Đăng ký thành công!');
    }
}
