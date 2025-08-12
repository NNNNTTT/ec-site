<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'laravel')}}</title>
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN（最新版） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-d8zW+...略...==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
</head>
<body>
    <nav class='navbar navbar-light bg-light'>
        <div class='container'>
            <a href="{{ route('product.index') }}" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>

            <div class="d-flex gap-3 align-items-center">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">logout</button>
                    </form>
                @endauth
                @guest
                    <form method="GET" action="{{ route('login') }}">
                        <button type="submit" class="btn btn-outline-secondary">login</button>
                    </form>
                    <form method="GET" action="{{ route('register') }}">
                        <button type="submit" class="btn btn-outline-secondary">register</button>
                    </form>
                @endguest
                <a href="{{ route('cart.index') }}" class="fas fa-shopping-cart" style="color:black"></a>
            </div>

        </div>
    </nav>
    @yield('content')
    <div class="admin_btn" style="position: fixed; bottom: 20px; right: 20px;">
        <a href="{{ route('admin.index') }}" class="btn btn-success">管理画面</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>