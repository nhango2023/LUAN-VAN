<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    //
    public function show()
    {

        $tasks = [];
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $payments = DB::table('payments')
            ->leftJoin('plans', 'payments.id_plan', '=', 'plans.id')
            ->join('additional_questions', 'payments.id_additional_questions', '=', 'additional_questions.id')
            ->join('users', 'users.id', '=', 'payments.id_user')
            ->select(
                'plans.name as plan_name',
                'plans.price as plan_price',
                'additional_questions.price as additional_question_price',
                'payments.*',
                'users.fullname'
            )
            ->orderBy('payments.created_at', 'desc')
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
            $id_user = $payment->id_user;
            $extra_question = $payment->extra_questions;
            $plan_bonus_questions = 0;
            if ($id_plan) {
                $plan = Plan::where('id', $id_plan)->first();
                $plan_bonus_questions = $plan->questions_limit;
                UserPlan::where('id_user', $id_user)->delete();
                $userPlan = new UserPlan();
                $userPlan->id_user = $id_user;
                $userPlan->id_plan = $id_plan;
                $userPlan->start_date = Carbon::now();
                $userPlan->end_date = Carbon::now()->addDays($plan->duration);
                $userPlan->save();
            }
            $user = User::find($id_user);
            $user->available_question = $plan_bonus_questions + $user->available_question + $extra_question;
            $user->save();
        }
        if ($action == 'cancel') {
            $payment->status = 'failed';
            $payment->save();
        }
        return redirect()->route('admin.payment.show')->with('success', 'Payment updated successfully!');
    }
}
