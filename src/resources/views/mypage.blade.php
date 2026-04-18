@extends('layouts.default')

@section('title','マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/index.css')  }}">
<link rel="stylesheet" href="{{ asset('/css/mypage.css')  }}">
@endsection

@section('content')

@include('components.header')
<div class="container">
    <div class="user">
        <div class="user__info">
            <div class="user__img">
                @if (isset($user->profile->img_url))
                <img class="user__icon" src="{{ \Storage::url($user->profile->img_url) }}" alt="">
                @else
                <img id="myImage" class="user__icon" src="{{ asset('img/icon.png') }}" alt="">
                @endif
            </div>
            <div class="user__text-content">
                <p class="user__name">{{$user->name}}</p>
                <!-- 追加した平均評価機能 -->
                <div class="user__rating">
                    @php $stars = $user->averageStars(); @endphp
                    @if($stars)
                    @for ($i = 1; $i <= 5; $i++)
                        <img src="{{ asset($i <= $stars ? 'img/rate_star.png' :'img/ignore_star.png') }}" class="star-icon">
                        @endfor
                        @endif
                </div>
            </div>

        </div>
        <div class="mypage__user--btn">
            <a class="btn2" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
    <div class="border">
        <ul class="border__list">
            <li class="{{ $page == 'sell' ? 'active' : '' }}"><a href="/mypage?page=sell">出品した商品</a></li>
            <li class="{{ $page == 'buy' ? 'active' : '' }}"><a href="/mypage?page=buy">購入した商品</a></li>
            <li class="{{ $page == 'chat' ? 'active' : '' }}">
                <a href="/mypage?page=chat" style="color: {{ $page == 'chat' ? 'red' : '' }}">
                    取引中の商品
                    @if(isset($totalUnread) && $totalUnread > 0)
                    <span class="nav-unread-badge">{{ $totalUnread }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
    <div class="items">
        @foreach ($items as $item)
        <div class="item">
            <a href="{{ $page == 'chat' ? route('chat.view', ['item_id' => $item->id]) : url('/item/'.$item->id) }}">
                <div class="item__img--container {{ $item->sold() ? 'sold' : '' }}">
                    <img src="{{ \Storage::url($item->img_url) }}" class="item__img">
                    @php
                    $unreadCount = $item->messages()->where('user_id', '!=', Auth::id())->whereNull('read_at')->count();
                    @endphp
                    @if($page == 'chat' && $unreadCount > 0)
                    <div class="unread-badge">{{ $unreadCount }}</div>
                    @endif
                </div>
                <p class="item__name">{{$item->name}}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection