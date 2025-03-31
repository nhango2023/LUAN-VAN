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


            $path = Storage::disk('public')->putFileAs('avatars', $file, $filename);


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
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'fullname' => 'required|string|max:255',
        ], [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu không được để trống.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
            'fullname.required' => 'Họ tên không được để trống.'
        ]);


        if (User::where('email', $req->email)->exists()) {
            return back()->with('error', 'Email đã tồn tại.')->withInput();
        }


        $user = new User();
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->fullname = $req->fullname;
        $user->dia_chi = $req->address;
        $user->sdt = $req->phone;
        $user->username = $req->email;
        $user->level = 'user';
        $user->status = 1;

        // ✅ Nếu có avatar được chọn
        if ($req->hasFile('avatar')) {
            $file = $req->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('avatars', $file, $filename);
            $user->avatar = $path;
        }

        // ✅ Lưu vào DB
        $user->save();

        return redirect()->route('admin.user.create')->with('success', 'Thêm người dùng thành công!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return back()->with('success', 'Người dùng đã bị xóa.');
    }
}
