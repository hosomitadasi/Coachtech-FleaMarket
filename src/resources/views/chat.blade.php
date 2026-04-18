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

            @if($item->soldItem->user_id === Auth::id() && $item->soldItem->status === 0)
            <button type="button" class="btn-complete" id="complete-btn">取引を完了する</button>
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

@php
$isSeller = ($item->user_id === Auth::id());
$alreadyRated = \App\Models\Evaluation::where('item_id', $item->id)->where('evaluator_id', Auth::id())->exists();
$showAutoModal = ($isSeller && $item->soldItem->status === 1 && !$alreadyRated);
@endphp

<div id="evaluation-modal" class="modal-overlay" style="{{ $showAutoModal ? 'display: flex;' : 'display: none;' }}">
    <div class="evaluation-modal">
        <h3>取引が完了しました。</h3>
        <p>今回の取引相手はどうでしたか？</p>
        <form action="{{ route('evaluation.store', $item->id) }}" method="POST">
            @csrf
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="star" value="{{ $i }}" required>
                <label for="star{{ $i }}">★</label>
                @endfor
            </div>
            <button type="submit" class="btn-send-eval">送信する</button>
            @if(!$showAutoModal)
            <button type="button" id="close-modal" class="btn-close">キャンセル</button>
            @endif
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorDiv = document.getElementById('error-messages');
        if (errorDiv && errorDiv.dataset.errors) {
            alert(errorDiv.dataset.errors);
        }

        const editBtns = document.querySelectorAll('.edit-btn');
        const textarea = document.getElementById('chat-textarea');
        const form = document.getElementById('chat-form');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const text = this.dataset.text;
                if (textarea) {
                    textarea.value = text;
                    textarea.focus();
                }
                if (form) {
                    form.action = `/chat/update/${id}`;
                }

                const submitIcon = document.getElementById('submit');
                if (submitIcon) {
                    submitIcon.style.filter = "hue-rotate(180deg)";
                }
            });
        });

        const completeBtn = document.getElementById('complete-btn');
        const modal = document.getElementById('evaluation-modal');
        const closeModal = document.getElementById('close-modal');

        if (completeBtn && modal) {
            completeBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });
        }

        if (closeModal && modal) {
            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        }
    });
</script>
@endsection