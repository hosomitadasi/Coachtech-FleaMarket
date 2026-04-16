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
    public function chatView($item_id)
    {
        $user = Auth::user();
        $item = Item::with(['soldItem', 'messages.user.profile'])->findOrFail($item_id);

        $partner = ($item->user_id === $user->id)
            ? User::find($item->soldItem->user_id)
            : $item->user;

        $other_items = Item::whereHas('soldItem')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('soldItem', fn($q) => $q->where('user_id', $user->id));
            })
            ->where('id', '!=', $item_id)
            ->get();

        return view('chat', compact('user', 'item', 'partner', 'other_items'));
    }

    public function chatCreate($item_id, MessageRequest $request)
    {
        $img_url = null;
        if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('public/chat');
        }

        Message::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'text' => $request->text,
            'img_url' => $img_url,
        ]);

        return back();
    }

    public function chatUpdate(MessageRequest $request)
    {
        return back('chat', compact(''));
    }

    public function chatDelete($chat_id)
    {
        Message::where(['user_id' => Auth::id(), 'chat_id' => $chat_id])->delete();
        return back();
    }
}
