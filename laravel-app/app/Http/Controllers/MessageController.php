<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MessageModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    //
    public function show(Request $request)
    {
        $id_user = Auth::user()->id;

        // Determine how many messages to fetch, defaulting to 5
        $limit = $request->input('limit', 5);

        $messages = MessageModel::join('uploaded_files', 'uploaded_files.id', '=', 'messages.id_file')
            ->where('uploaded_files.id_user', $id_user)
            ->select('messages.id', 'messages.id_file', 'messages.created_at', 'messages.seen', 'uploaded_files.original_name')
            ->orderBy('messages.created_at', 'desc')
            ->take($limit) // Limit the number of messages
            ->get();

        $formatted = $messages->map(function ($item) {
            return [
                'id' => $item->id,
                'id_file' => $item->id_file,
                'original_name' => $item->original_name,
                'seen' => $item->seen,
                'created_at' => Carbon::parse($item->created_at)
                    ->timezone('Asia/Ho_Chi_Minh')
                    ->format('Y-m-d H:i:s'),
            ];
        });

        $hasMore = $messages->count() >= $limit;

        return response()->json([
            'messages' => $formatted,
            'has_more' => $hasMore,
        ]);
    }



    public function update($id_message)
    {

        $message = MessageModel::where('id', $id_message)
            ->where('seen', 0)
            ->first();

        if ($message) {
            $message->seen = 1;
            $message->save();
            return response()->json(['message' => 'Message updated successfully.']);
        }

        return response()->json(['message' => 'No update needed or message not found.'], 404);
    }
}
