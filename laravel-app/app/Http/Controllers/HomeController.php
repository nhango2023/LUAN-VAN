<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()


    {
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $user = Auth::User();
        if ($user) {
            $tasks = Task::where('id_user', $user->id)->where('status', 'processing')->get();
            return view('home', compact('configWeb', 'tasks'));
        }
        return view('home', compact('configWeb'));
    }
}
