<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use App\Models\Item;
use App\Http\Requests\ChatRequest;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function chatView()
    {

        return view('chat', compact(''));
    }

    public function chatCreate(ChatRequest $request)
    {

        return view('chat', compact(''));
    }

    public function chatUpdate(ChatRequest $request)
    {
        return view('chat', compact(''));
    }

    public function chatDelete($chat_id)
    {
        Message::where(['user_id' => Auth::id(), 'chat_id' => $chat_id])->delete();
        return back();
    }
}
