<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class aiModelController extends Controller
{
    public function show()
    {
        $AiModel = DB::table('ai_model')->get();

        return view('admin.ai-model-management.ai-model', ['AiModel' => $AiModel]);
    }
    public function editApiKey(Request $req)
    {
        $id = $req->id;
        $validator = Validator::make($req->all(), [
            'api_key' => 'required',
        ], [
            'api_key.required' => 'API key cannot be empty.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'ai_model_' . $id)
                ->withInput();
        }

        $aiModel = AiModel::find($id);

        if ($aiModel) {
            $api_key = $req->api_key;
            $aiModel->api_key = $api_key;
            $aiModel->save();

            // Optionally, redirect or return response
            return redirect()->back()->with('success', 'API key updated successfully!');
        };
    }
}
