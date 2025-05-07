<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //
    public function create(Request $req)
    {
        $req->validate([
            'url_api' => 'required',
            'api_key' => 'required',
        ]);
        $this->setEnvValue('API_URL', $req->url_api);
        $this->setEnvValue('API_KEY', $req->api_key);
        return redirect('/')->with('success', 'ENV variable updated!');
    }

    protected function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');
        $escaped = preg_quote('=' . $value, '/');

        if (file_exists($envPath)) {
            $env = file_get_contents($envPath);

            // Check if the key exists already
            if (strpos($env, "$key=") !== false) {
                // Replace existing
                $env = preg_replace("/^$key=.*$/m", "$key=\"$value\"", $env);
            } else {
                // Append new line
                $env .= "\n$key=\"$value\"";
            }

            file_put_contents($envPath, $env);
            return true;
        }

        return false;
    }
}
