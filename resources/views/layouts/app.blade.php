
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- csrfTokenをmetaデータに格納 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') | {{ config('app.name', 'laravel')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
    <link rel="stylesheet" href="@yield('css')">
    <!-- Font Awesome CDN（最新版） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-d8zW+...略...==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<style>
    @media (max-width: 1000px) {
        .admin_btn{
            display: none;
        }
    }

    svg {
        width: 25px;
        height: 25px;
        fill: black; /* 色を指定 */
    }
</style>
<body>
    <header>
        <nav class='navbar navbar-light bg-light'>
            <div class='container'>
                <a href="/" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>

                <div class="d-flex gap-3 align-items-center">
                    @auth
                        <a href="{{ route('mypage.index') }}" class="icon">
                            <i class="fa-regular fa-user icon-size"></i>
                            <p>マイページ</p>
                        </a>    
                        @php
                            $user = Auth::user();
                            $favorites = $user->favorites;
                        @endphp
                        @if($favorites->count() > 0)
                        <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form icon">
                            @csrf
                            <i class="fas fa-heart auth_favorite-icon icon-size"></i>
                            <p>お気に入り</p>
                            <input type="hidden" name="type" value="auth">
                        </form>
                        @else
                        <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form icon">
                            @csrf
                            <i class="far fa-heart auth_favorite-icon icon-size"></i>
                            <p>お気に入り</p>
                            <input type="hidden" name="type" value="auth">
                        </form>
                        @endif
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="icon">
                            <i class="fa-regular fa-user icon-size"></i>
                            <p class="m-0">ログイン</p>
                        </a>    
                        <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form icon">
                            @csrf
                            <i class="fa-heart guest_favorite-icon icon-size"></i>
                            <p class="m-0">お気に入り</p>
                            <input type="hidden" class="guest_favorite-input" name="favorites" value="">
                            <input type="hidden" name="type" value="guest">
                        </form>
                    @endguest

                    <a href="{{ route('cart.index') }}" class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" class="icon-size">
                            <path d="M21.3,4.6H7.7l-0.3-2C7.4,2.3,7.1,2,6.7,2H2.7C2.3,2,2,2.3,2,2.7c0,0.4,0.3,0.7,0.7,0.7H6L8,17c0.1,0.4,0.4,0.6,0.7,0.6h10c0.4,0,0.7-0.3,0.7-0.7c0-0.4-0.3-0.7-0.7-0.7H9.4l-0.4-2.5h9.8c0.4,0,0.7-0.2,0.7-0.6l1.5-7h0.2c0.4,0,0.7-0.3,0.7-0.7C22,5,21.7,4.6,21.3,4.6z M18.2,12.2H8.8L7.9,6.1h11.6L18.2,12.2z M9.3,18.2c-1.1,0-1.9,0.9-1.9,1.9S8.3,22,9.3,22c1.1,0,1.9-0.9,1.9-1.9c0,0,0,0,0,0C11.2,19,10.4,18.2,9.3,18.2z M9.3,20.9c-0.4,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8c0.4,0,0.8,0.4,0.8,0.8C10.1,20.5,9.8,20.9,9.3,20.9L9.3,20.9z M18.4,18.2c-1.1,0-1.9,0.9-1.9,1.9s0.9,1.9,1.9,1.9c1.1,0,1.9-0.9,1.9-1.9c0,0,0,0,0,0C20.3,19,19.5,18.2,18.4,18.2z M18.4,20.9c-0.4,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8c0.4,0,0.8,0.4,0.8,0.8C19.2,20.5,18.9,20.9,18.4,20.9L18.4,20.9z"></path>
                        </svg>
                        <p>カート</p>
                    </a>

                    <div class="hamburger d-xl-none">
                        <i class="fas fa-bars"></i>
                    </div>
                    @include('partials.sp-nav')
                </div>

            </div>
        </nav>
    </header>
    @yield('content')
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <h3>CATEGORY</h3>
                    <ul>
                        <li><a href="">Tシャツ</a></li>
                        <li><a href="">シャツ</a></li>
                        <li><a href="">ポロシャツ</a></li>
                        <li><a href="">ブルゾン</a></li>
                        <li><a href="">ジャケット</a></li>
                        <li><a href="">ダウン</a></li>
                        <li><a href="">ジーンズ</a></li>
                        <li><a href="">スラックス</a></li>
                        <li><a href="">チノパン</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h3>SHOPPING GUIDE</h3>
                    <ul>
                        <li><a href="">ログイン・会員登録</a></li>
                        <li><a href="">マイページ</a></li>
                        <li><a href="">お問い合わせ</a></li>
                        <li><a href="">ご利用ガイド</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h3>OTHER MENU</h3>
                    <ul>
                        <li><a href="">プライバシーポリシー</a></li>
                        <li><a href="">特定商取引法に基づく表記</a></li>
                        <li><a href="">ご利用規約</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="admin_btn" style="position: fixed; bottom: 20px; right: 20px;">
        <a href="{{ route('admin.product.index') }}" class="btn btn-success" style="color: white;">管理画面</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- サーバー情報をJSに渡す -->
    <script>
        const isGuest = @json(auth()->guest());
        const hasFavoritesSession = @json(session()->has('favorites'));
    </script>

    <!-- 上記でfavoritesのセッション情報を変数に格納した後セッションを削除する -->
    @php
    if(session()->has('favorites')) {
        session()->forget('favorites');
    }
    @endphp


    <script src="{{ asset('js/layouts/app.js') }}"></script>
    <script src="@yield('js')"></script>
</body>
</html>