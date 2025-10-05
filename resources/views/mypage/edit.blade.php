@extends('layouts.app')

@section('title', 'アカウント情報の編集')

@section('content')
<style>
    .form-group input {
        max-width: 500px;
    }
</style>
<div class="container mt-5">
    <h2 class="mb-5">アカウント情報の編集</h2>
    <form action="{{ route('mypage.update') }}" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
            @if($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
            @if($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="phone" class="form-label">電話番号</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
            @if($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="postal_code" class="form-label">郵便番号</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ Auth::user()->postal_code }}">
            @if($errors->has('postal_code'))
                <span class="text-danger">{{ $errors->first('postal_code') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="prefecture" class="form-label">都道府県</label>
            <input type="text" class="form-control" id="prefecture" name="prefecture" value="{{ Auth::user()->prefecture }}">
            @if($errors->has('prefecture'))
                <span class="text-danger">{{ $errors->first('prefecture') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="address" class="form-label">ご住所（市区町村-番地）</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ Auth::user()->address }}">
            @if($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-outline-secondary mt-3">更新する</button>
        <a href="{{ route('mypage.index') }}" class="btn btn-outline-secondary mt-3 mx-3">戻る</a>
    </form>
</div>
@endsection