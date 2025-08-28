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
    }
</style>
<x-guest-layout>

<x-auth-session-status class="mb-4" :status="session('status')" />

<div class='auth-container'>
    <input class="form-check-input login-tab mr-3" type="radio" name="authTab" id="tabLogin" value="login" checked>
    <label class="form-check-label mb-3" for="tabLogin">ログイン</label>

    <div class="login-container mb-4 pb-3 border-bottom">

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

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れた方はこちら') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('ログイン') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <input class="form-check-input register-tab" type="radio" name="authTab" id="tabRegister" value="register">
    <label class="form-check-label mb-3" for="tabRegister">会員登録がお済みでない方</label>
    <div class="register-container">

        <form method="POST" action="{{ route('register') }}" class="register-form" style="display: none;">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('名前')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-input-label for="phone" :value="__('電話番号')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Postal code -->
            <div class="mt-4">
                <x-input-label for="phone" :value="__('郵便番号')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required />
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
            </div>

            <!-- Prefecture -->
            <div class="mt-4">
                <x-input-label for="prefecture" :value="__('都道府県')" />
                <x-text-input id="prefecture" class="block mt-1 w-full" type="text" name="prefecture" :value="old('prefecture')" required />
                <x-input-error :messages="$errors->get('prefecture')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="__('住所')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('パスワード')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('パスワード確認')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-primary-button class="ms-4">
                    {{ __('登録') }}
                </x-primary-button>
            </div>
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
</x-guest-layout>
@endsection

