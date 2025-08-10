@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('content')
<style>
    .auth-container {
        max-width: 400px;
        margin: 5% auto;
        padding: 2rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
</style>

<div class='auth-container'>
    <input class="form-check-input login-tab" type="radio" name="authTab" id="tabLogin" value="login" checked>
    <label class="form-check-label" for="tabLogin">ログイン</label>

    <div class="login-container mb-3 pb-3 border-bottom">

        <form method="POST" action="{{ route('order.login') }}" class="login-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="btn btn-primary w-100">ログイン</button>
        </form>
    </div>

    <input class="form-check-input register-tab" type="radio" name="authTab" id="tabRegister" value="register">
    <label class="form-check-label" for="tabRegister">会員登録がお済みでない方</label>
    <div class="register-container">

        <form method="POST" action="{{ route('order.register') }}" class="register-form" style="display: none;">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">名前</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">電話番号</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>

            <div class="mb-3">
                <label for="postal_code" class="form-label">郵便番号</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">都道府県</label>
                <input type="text" class="form-control" id="prefecture" name="prefecture" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">市区町村</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">パスワード確認</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">会員登録</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.login-tab').click(function(){
            $('.login-form').slideToggle();
            $('.register-form').slideUp();
        });
        $('.register-tab').click(function(){
            $('.register-form').slideToggle();
            $('.login-form').slideUp();
        });
    });
</script>
@endsection

