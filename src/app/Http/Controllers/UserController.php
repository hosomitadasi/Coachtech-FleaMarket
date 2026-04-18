<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;
use App\Models\Item;
use App\Models\SoldItem;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
    {

        $profile = Profile::where('user_id', Auth::id())->first();

        return view('profile', compact('profile'));
    }

    public function updateProfile(ProfileRequest $request)
    {

        $img = $request->file('img_url');
        if (isset($img)) {
            $img_url = Storage::disk('local')->put('public/img', $img);
        } else {
            $img_url = '';
        }

        $profile = Profile::where('user_id', Auth::id())->first();
        if ($profile) {
            $profile->update([
                'user_id' => Auth::id(),
                'img_url' => $img_url,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building
            ]);
        } else {
            Profile::create([
                'user_id' => Auth::id(),
                'img_url' => $img_url,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building
            ]);
        }

        User::find(Auth::id())->update([
            'name' => $request->name
        ]);

        return redirect('/');
    }

    public function mypage(Request $request)
    {
        $user = User::with('profile')->find(Auth::id());
        $page = $request->query('page', 'buy');
        if ($page == 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($page == 'chat') {
            $items = Item::whereHas('soldItem')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhereHas('soldItem', fn($q) => $q->where('user_id', $user->id));
                })
                ->withCount(['messages as unread_messages_count' => function ($query) {
                    $query->where('user_id', '!=', Auth::id())->whereNull('read_at');
                }])
                ->orderByRaw('(SELECT MAX(created_at) FROM messages WHERE messages.item_id = items.id) DESC')
                ->orderBy('updated_at', 'desc')
                ->get();

            $totalUnread = $items->sum('unread_messages_count');
            view()->share('totalUnread', $totalUnread);
        } else {
            $items = SoldItem::where('user_id', $user->id)->get()->map(fn($si) => $si->item);
        }
        return view('mypage', compact('user', 'items', 'page'));
    }
}
