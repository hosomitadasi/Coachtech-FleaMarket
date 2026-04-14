<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'evaluator_id',
        'item_id',
        'stars',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function evaluator()
    {
        return $this->belongsTo('App\Models\User', 'evaluator_id');
    }
}
