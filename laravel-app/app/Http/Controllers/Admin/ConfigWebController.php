<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use Illuminate\Http\Request;

class ConfigWebController extends Controller
{
    public function show()
    {
        $configWeb = Configweb::all();
        return view('admin.config-web-management.home', compact('configWeb'));
    }
    public function showDetail($id)
    {
        // Get the configweb entry with the specific id
        $configWeb = ConfigWeb::find($id);

        // If the configWeb entry doesn't exist, you can return a 404 or redirect
        if (!$configWeb) {
            abort(404, 'Config Web not found');
        }

        // Pass the retrieved configWeb data to the view
        return view('admin.config-web-management.detail', compact('configWeb'));
    }
}
