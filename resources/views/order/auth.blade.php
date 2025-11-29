@extends('layouts.app')

@section('title')
ログイン・会員登録
@endsection

@section('css', asset('css/order/auth.css'))

@section('content')

<style>
    .auth-container {
        max-width: 400px;
        margin: 5% auto;
        padding: 2rem;
        background: white;
    }
</style>
<x-guest-layout>

<x-auth-session-status class="mb-4" :status="session('status')" />

<div class='auth-container'>

    <div class="auth_radio">
        <input class="form-check-input login-tab" type="radio" name="authTab" id="tabLogin" value="login" checked>
        <label class="form-check-label" for="tabLogin">ログイン</label>
    </div>
    <div class="login-container mb-4">

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div>
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('パスワード')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('ログイン状態を保持する') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-2">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れた方はこちら') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="login_btn">ログイン</button>

            <!-- jsでローカルのお気に入り情報を取得してここに格納します -->
            <input type="hidden" name="favorites_data" value="">
        </form>
    </div>

    <div class="auth_radio">
        <input class="form-check-input register-tab" type="radio" name="authTab" id="tabRegister" value="register">
        <label class="form-check-label" for="tabRegister">会員登録がお済みでない方</label>
    </div>
    <div class="register-container">

        <form method="POST" action="{{ route('register') }}" class="register-form" style="display: none;">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('お名前')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="register_email" :value="old('register_email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('register_email')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-input-label for="phone" :value="__('電話番号')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Postal code -->
            <div class="mt-4">
                <x-input-label for="postal_code" :value="__('郵便番号')" />
                <div class="postal_code_container">
                    <x-text-input id="postal_code_1" class="block mt-1" type="text" name="postal_code1" :value="old('postal_code')" required />
                    <span class="postal_code_text">-</span>
                    <x-text-input id="postal_code_2" class="block mt-1" type="text" name="postal_code2" :value="old('postal_code')" required />
                </div>
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                <button type="button" class="postal_code_btn">住所検索</button>
            </div>

            <!-- Prefecture -->
            <div class="mt-4">
                <x-input-label for="prefecture" :value="__('都道府県')" />
                <select id="prefecture" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="prefecture" :value="old('prefecture')" required>
                    <option value="1">北海道</option>
                    <option value="2">青森県</option>
                    <option value="3">岩手県</option>
                    <option value="4">宮城県</option>
                    <option value="5">秋田県</option>
                    <option value="6">山形県</option>
                    <option value="7">福島県</option>
                    <option value="8">茨城県</option>
                    <option value="9">栃木県</option>
                    <option value="10">群馬県</option>
                    <option value="11">埼玉県</option>
                    <option value="12">千葉県</option>
                    <option value="13">東京都</option>
                    <option value="14">神奈川県</option>
                    <option value="15">新潟県</option>
                    <option value="16">富山県</option>
                    <option value="17">石川県</option>
                    <option value="18">福井県</option>
                    <option value="19">山梨県</option>
                    <option value="20">長野県</option>
                    <option value="21">岐阜県</option>
                    <option value="22">静岡県</option>
                    <option value="23">愛知県</option>
                    <option value="24">三重県</option>
                    <option value="25">滋賀県</option>
                    <option value="26">京都府</option>
                    <option value="27">大阪府</option>
                    <option value="28">兵庫県</option>
                    <option value="29">奈良県</option>
                    <option value="30">和歌山県</option>
                    <option value="31">鳥取県</option>
                    <option value="32">島根県</option>
                    <option value="33">岡山県</option>
                    <option value="34">広島県</option>
                    <option value="35">山口県</option>
                    <option value="36">徳島県</option>
                    <option value="37">香川県</option>
                    <option value="38">愛媛県</option>
                    <option value="39">高知県</option>
                    <option value="40">福岡県</option>
                    <option value="41">佐賀県</option>
                    <option value="42">長崎県</option>
                    <option value="43">熊本県</option>
                    <option value="44">大分県</option>
                    <option value="45">宮崎県</option>
                    <option value="46">鹿児島県</option>
                    <option value="47">沖縄県</option>
                    </select>
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="__('住所（市町村番地・建物名）')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('パスワード')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="register_password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('register_password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('パスワード確認')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="register_password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('register_password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="register_btn">会員登録</button>

            <!-- jsでローカルのお気に入り情報を取得してここに格納します -->
            <input type="hidden" name="favorites_data" value="">

        </form>
    </div>
</div>
</x-guest-layout>

<!-- 会員登録のバリデーションエラーの場合下記処理を行う -->
@if(session()->has('auth_tab') && session('auth_tab') == 'register')
<script>
    $authTab = '{{ session('auth_tab') }}';
</script>
@endif

<script src="{{ asset('js/auth/login.js') }}"></script>
@endsection

@section('js', asset('js/order/auth.js'))

