<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator as ValidationValidator;

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
    public function syncApiKey(Request $request)
    {
        try {
            // Call the FastAPI backend
            $fastApiUrl = env('API_URL') . 'update-api-key?model_name=' . urlencode($request->model_name) . '&api_key=' . urlencode($request->api_key);

            $Response = Http::put($fastApiUrl);

            if ($Response->successful()) {

                $aiModel = AiModel::find($request->id_model);
                if ($aiModel) {
                    $aiModel->isSync = 1;
                    $aiModel->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'API key synced and database updated.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'FastAPI error: ' . $Response->body()
                ], 500);
            }
        } catch (ValidationValidator $ve) {
            log::debug($ve);
            return response()->json(['success' => false, 'message' => $ve->getMessage()], 422);
        } catch (\Exception $e) {
            // Any other error
            log::debug($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
