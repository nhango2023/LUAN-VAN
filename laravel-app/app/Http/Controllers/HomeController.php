<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use App\Models\Plan;
use App\Models\Task;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function show()
    {
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $user = Auth::user();
        $currentPlan = "";
        $tasks = [];
        // Check if user is <authen></authen>ticated and fetch tasks
        if ($user) {
            $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
                ->where('tasks.id_user', $user->id)
                ->where('tasks.status', 'processing')
                ->select('tasks.*', 'uploaded_files.original_name')
                ->get();

            $currentPlan = UserPlan::join('plans', 'user_plan.id_plan', '=', 'plans.id')
                ->where('user_plan.id_user', $user->id)
                ->select('plans.id as plan_id', 'plans.name as name', 'user_plan.end_date')
                ->first();
        }
        return view('home', compact('configWeb', 'tasks', 'currentPlan'));
    }
}
