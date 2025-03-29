<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('level', 'user')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('admin.user-management.user', compact('users'));
    }
    public function showFormPersonal($id)
    {

        $user = User::findOrFail($id); // tìm user theo ID
        return view('admin.user-management.personal-edit', compact('user'));
    }
    public function updatePersonalInfor(Request $req, $id)
    {
        $user = User::findOrFail($id);

        $user->fullname = $req->input('fullname');
        $user->dia_chi = $req->input('address');
        $user->sdt = $req->input('phone');

        if ($req->hasFile('avatar')) {
            $file = $req->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // ✅ Ghi file vào storage/app/public/avatars
            $path = Storage::disk('public')->putFileAs('avatars', $file, $filename);

            // ✅ Xoá file cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // ✅ Lưu đường dẫn
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
    public function showFormCreate()
    {
        return view('admin.user-management.create-form');
    }
    public function create(Request $req)
    {
        // Kiểm tra email đã tồn tại
        if (User::where('email', $req->input('email'))->exists()) {
            return back()->with('error', 'Email đã tồn tại.')->withInput();
        }
        // Kiểm tra xác nhận mật khẩu
        if ($req->input('password') !== $req->input('confirm_password')) {
            return back()->with('error', 'Mật khẩu xác nhận không khớp.')->withInput();
        }

        // Tạo user mới
        $user = new User();
        $user->fullname = $req->input('full_name');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->sdt = $req->input('phone_number');
        $user->dia_chi = $req->input('address');
        $user->username = $req->input('email');
        $user->level = 'user';
        $user->status = '1';

        $user->save();

        return redirect()->route('admin.user.createcreate')->with('success', 'Thêm người dùng thành công!');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return back()->with('success', 'Người dùng đã bị xóa.');
    }
}
