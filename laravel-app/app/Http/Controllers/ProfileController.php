<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showAccountInfor()
    {
        return view('user-profile.account-infor');
    }
    public function updateFullName(Request $req)
    {
        $req->validate([
            'fullname' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $user->fullname = $req->input('fullname');
        $user->save();

        return redirect()->back()->with('success', 'Full name updated!');
    }
    public function updatePassword(Request $request)
    {
        // Get the current authenticated user
        $user = Auth::user();

        // Check if the old password matches the stored password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        $request->validate([
            'new_password' => 'required',
            'confirm_new_password' => 'required',
        ]);

        // Check if the new password and confirm new password match
        if ($request->input('new_password') !== $request->input('confirm_new_password')) {
            return back()->withErrors(['confirm_new_password' => 'The new password and confirmation do not match.']);
        }

        // Update the password if all checks pass
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect or return with success message
        return back()->with('success', 'Password updated successfully!');
    }
    public function showBuyCredit()
    {
        return view('user-profile.buy-credit');
    }
}
