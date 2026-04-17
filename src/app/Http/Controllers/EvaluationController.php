<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Evaluation;
use App\Notifications\TradeCompleted;

class EvaluationController extends Controller
{
    public function store(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::with('soldItem')->findOrFail($item_id);
        $soldItem = $item->soldItem;

        $to_user_id = ($item->user_id === $user->id) ? $soldItem->user_id : $item->user_id;

        Evaluation::create([
            'user_id' => $to_user_id,
            'evaluator_id' => $user->id,
            'item_id' => $item_id,
            'stars' => $request->star,
        ]);

        if ($user->id === $soldItem->user_id) {
            $soldItem->status = 1;
            $item->user->notify(new TradeCompleted($item));
        } else {
            $soldItem->status = 2;
        }
        $soldItem->save();

        return redirect('/')->with('message', '取引評価が完了しました');
    }
}
