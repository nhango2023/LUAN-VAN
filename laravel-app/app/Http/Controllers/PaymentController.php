<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function show()
    {

        $tasks = [];
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $payments = Payment::join('users', 'users.id', '=', 'payments.id_user')
            ->join('plans', 'plans.id', '=', 'payments.id_plan')
            ->select('payments.id', 'payments.created_at', 'payments.status', 'plans.name', 'plans.price', 'users.fullname')
            ->get();

        return view('admin.payment.home', compact('configWeb', 'tasks', 'payments'));
    }
    public function update($id_payment, $action)
    {
        $payment = Payment::find($id_payment);

        if ($action == 'confirm') {
            $payment->status = 'success';
            $payment->save();

            $id_plan = $payment->id_plan;

            $plan = Plan::find($id_plan);

            $id_user = $payment->id_user;
            $user = User::find($id_user);
            $user->id_plan = $id_plan;
            $user->available_question = $plan->questions_limit + $user->available_question;
            $user->save();
        }
        if ($action == 'cancel') {
            $payment->status = 'failed';
            $payment->save();
        }
        return redirect()->route('admin.payment.show')->with('success', 'Payment updated successfully!');
    }
}
