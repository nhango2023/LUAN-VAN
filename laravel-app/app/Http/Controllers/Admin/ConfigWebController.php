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

    public function updateWebConfig(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'keywords' => 'required|string',
            'description' => 'required|string',
        ]);

        $config = ConfigWeb::findOrFail($id);

        $config->title = $request->title;
        $config->keywords = $request->keywords;
        $config->web_description = $request->description;

        $config->save();

        return response()->json(['success' => true]);
    }

    public function updateCompanyConfig(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'facebook_link' => 'required|string',
            'address' => 'required|string',
            'company_description' => 'required|string',
        ]);

        $config = ConfigWeb::findOrFail($id);

        $config->email = $request->email;
        $config->phone_number = $request->phone_number;
        $config->facebook_link = $request->facebook_link;
        $config->address = $request->address;
        $config->company_description = $request->company_description;

        $config->save();

        return response()->json(['success' => true]);
    }
}
