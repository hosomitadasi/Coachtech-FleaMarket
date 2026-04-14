<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    // 以降追加機能部分

    // チャット機能
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 自分が受け取った評価機能
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'user_id');
    }

    // 自分が行った評価機能
    public function reviewsDone()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    public function averageStars()
    {
        // 評価が一件もない場合は null または 0 を返す
        $avg = $this->evaluations()->avg('stars');
        return $avg ? (int)round($avg) : null;
    }
}
