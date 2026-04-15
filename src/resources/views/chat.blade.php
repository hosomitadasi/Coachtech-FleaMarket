@extends('layouts.default')

@section('title','取引チャットページ')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/chat.css')  }}">
@endsection

@section('content')

@include('components.header')
<div class="container">
    <div class="sideview"></div>

    <div class="user__info">
        <div class="user__img">
            @if (isset($user->profile->img_url))
            <img class="user__icon" src="{{ \Storage::url($user->profile->img_url) }}" alt="">
            @else
            <img id="myImage" class="user__icon" src="{{ asset('img/icon.png') }}" alt="">
            @endif
        </div>
        <p class="user__name">{{$user->name}}</p>
    </div>

    <div class="item">
        <div class="item__img">
            <img src="{{ \Storage::url($item->img_url) }}" alt="商品画像">
        </div>
        <h2 class="item__name">{{$item->name}}</h2>
        <p class="item__price">¥ {{number_format($item->price)}}</p>
    </div>
    <form>

    </form>
    <form>
        <textarea name="" id="" class="input textarea"></textarea>
        <button><img class="user__icon" src="{{ asset('img/input_button.png') }}" alt=""></button>
        <div class="form__error">
            @error('')
            {{ $message }}
            @enderror
        </div>
    </form>

</div>

<script src=""></script>
@endsection