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
        @endforeach
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
                    @if(!$msg->img_url)
                    <button type="button" class="edit-btn" data-id="{{ $msg->id }}" data-text="{{ $msg->text }}">編集</button>
                    @endif
                    <form action="{{ route('chat.delete', $msg->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <form action="/chat/{{ $item->id }}" method="POST" enctype="multipart/form-data" class="chat-form" id="chat-form">
            @csrf
            <input type="hidden" name="message_id" id="edit-id">
            <textarea name="text" id="chat-textarea" placeholder="取引メッセージを記入してください"></textarea>
            <input type="file" name="img_url" id="chat-file">
            <button type="submit"><img id="submit" class="input_button" src="{{ asset('img/input_button.png') }}" alt=""></button>
        </form>

        @if ($errors->any())
        <div id="error-messages" data-errors="{{ implode('\n', $errors->all()) }}" style="display:none;"></div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorDiv = document.getElementById('error-messages');
        if (errorDiv) {
            alert(errorDiv.dataset.errors);
        }

        const editBtns = document.querySelectorAll('.edit-btn');
        const textarea = document.getElementById('chat-textarea');
        const form = document.getElementById('chat-form');
        const editIdInput = document.getElementById('edit-id');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const text = this.dataset.text;

                textarea.value = text;
                textarea.focus();

                form.action = `/chat/update/${id}`;

                document.getElementById('submit-btn').innerText = '更新';
            });
        });
    });
</script>
@endsection