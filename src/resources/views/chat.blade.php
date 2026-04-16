@extends('layouts.default')

@section('title','取引チャットページ')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/chat.css')  }}">
@endsection

@section('content')

@include('components.header')
<div class="chat-container">
    <div class="sideview">
        <h3>その他取引</h3>
        @foreach($other_items as $other)
        <a href="{{ route('chat.view', $other->id) }}" class="side-item">
            {{ $other->name }}
        </a>
    </div>

    <div class="main-chat">
        <div class="partner-info">
            <img src="{{ $partner->profile->img_url ? Storage::url($partner->profile->img_url) : asset('img/icon.png') }}" class="user__icon">
            <span>「{{ $partner->name }}」さんとの取引画面</span>

            @if($item->soldItem->user_id === Auth::id())
            <a href="/evaluation/{{ $item->id }}" class="btn-complete">取引を完了する</a>
            @endif
        </div>

        <div class="item-summary">
            <img src="{{ Storage::url($item->img_url) }}" alt="">
            <div>
                <h2>{{ $item->name }}</h2>
                <p>¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="message-area">
            @foreach($item->messages as $msg)
            <div class="message-box {{ $msg->user_id === Auth::id() ? 'my-message' : 'partner-message' }}">
                <p>{{ $msg->text }}</p>
                @if($msg->img_url)
                <img src="{{ Storage::url($msg->img_url) }}" class="chat-img">
                @endif

                @if($msg->user_id === Auth::id())
                <div class="msg-actions">
                    @if(!$msg->img_url) <button>編集</button> @endif
                    <form action="/chat/delete/{{ $msg->id }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <form action="/chat/{{ $item->id }}" method="POST" enctype="multipart/form-data" class="chat-form">
            @csrf
            <textarea name="text" placeholder="取引メッセージを記入してください"></textarea>
            <input type="file" name="img_url" id="chat-file">
            <button type="submit">送信</button>
        </form>
    </div>
</div>
@endsection