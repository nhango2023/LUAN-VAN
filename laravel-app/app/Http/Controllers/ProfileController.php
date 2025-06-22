<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdditionalQuestion;
use App\Models\Configweb;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showAccountInfor()
    {
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $plan = "";
        $user = Auth::user();
        // Check if user is authenticated and fetch tasks
        if ($user) {
            $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
                ->where('tasks.id_user', $user->id)
                ->where('tasks.status', 'processing')
                ->select('tasks.*', 'uploaded_files.original_name')
                ->get();

            $plan = Plan::find($user->id_plan);
            Log::debug($plan . '');
        } else {
            $tasks = [];  // Empty array if user is notauthenticated
        }
        return view('user-profile.account-infor', [
            'configWeb' => $configWeb,
            'tasks' => $tasks,
            'plan' => $plan
        ]);
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
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $user = Auth::user();
        $currentPlan = Plan::find($user->id_plan); // Lấy kế hoạch của user hiện tại

        $plans = Plan::orderBy('price', 'asc')->get();
        $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
            ->where('tasks.id_user', $user->id)
            ->where('tasks.status', 'processing')
            ->select('tasks.*', 'uploaded_files.original_name')
            ->get();
        $additionalQuestion = AdditionalQuestion::where('isActive', 1)->first();
        return view('user-profile.buy-credit', [
            'tasks' => $tasks,
            'currentPlan' => $currentPlan,  // Truyền biến kế hoạch vào view
            'plans' => $plans,
            'configWeb' => $configWeb,
            'additionalQuestion' => $additionalQuestion
        ]);
    }
    public function showPaymentPage(Request $request)
    {
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $user = Auth::user();
        $currentPlan = Plan::find($user->id_plan);
        $planId = $request->query('plan_id');
        $questions = $request->query('questions');

        //user only buy extra questions
        if (empty($planId)) {
            $planToPay = new Plan(); // create dummy plan with price = 0
            $planToPay->price = 0;
            $planToPay->name = "No plan selected";
            $planToPay->questions_limit = 0;
            $planToPay->processes = 0;
            $planToPay->description = '';
        } else {
            $planToPay = Plan::find($planId);

            // fallback if plan not found
        }
        $additionalQuestion = AdditionalQuestion::where('isActive', 1)->first();

        $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
            ->where('tasks.id_user', $user->id)
            ->where('tasks.status', 'processing')
            ->select('tasks.*', 'uploaded_files.original_name')
            ->get();


        return view('user-profile.payment', [
            'tasks' => $tasks,
            'additionalQuestion' => $additionalQuestion,
            'questions' => $questions,
            'planToPay' => $planToPay,
            'configWeb' => $configWeb,
            'currentPlan' => $currentPlan

        ]);
    }

    public function paymentConfirm($id_plan, $questions)
    {
        $user = Auth::user();
        $additionalQuestion = AdditionalQuestion::where('isActive', 1)->first();
        $payment = new Payment();
        $payment->id_user = $user->id; // ID người dùng
        $payment->id_plan = $id_plan;
        $payment->extra_questions = $questions;
        $payment->id_additional_questions = $additionalQuestion->id;
        $payment->status = 'pending'; // Trạng thái thanh toán
        $payment->save(); // Lưu vào cơ sở dữ liệu

        // Trả về thông báo thành công
        return redirect()->route('profile.buy-credit')->with('success', 'Thanh toán thành công!');
    }

    public function paymentHistory()
    {

        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $user = Auth::user();
        $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
            ->where('tasks.id_user', $user->id)
            ->where('tasks.status', 'processing')
            ->select('tasks.*', 'uploaded_files.original_name')
            ->get();

        $payments = Payment::join('plans', 'plans.id', '=', 'payments.id_plan')
            ->where('payments.id_user', $user->id)
            ->select('payments.status', 'payments.created_at', 'plans.name', 'plans.price')
            ->get();
        $plan = Plan::find($user->id_plan);
        return view('user-profile.payment-history', [
            'tasks' => $tasks,
            'payments' => $payments,
            'configWeb' => $configWeb,
            'currentPlan' => $plan,
        ]);
    }
}
