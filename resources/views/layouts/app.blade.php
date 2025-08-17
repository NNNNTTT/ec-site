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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<style>
    @media (max-width: 1000px) {
        .admin_btn{
            display: none;
        }
    }
</style>
<body>
    <nav class='navbar navbar-light bg-light'>
        <div class='container'>
            <a href="{{ route('product.index') }}" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>

            <div class="d-flex gap-3 align-items-center">
                @auth
                    <form method="GET" action="{{ route('mypage.index') }}">
                        <button type="submit" class="btn btn-outline-secondary">mypage</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">logout</button>
                    </form>
                    @php
                        $user = Auth::user();
                        $favorites = $user->favorites;
                    @endphp
                    @if($favorites->count() > 0)
                    <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form">
                        @csrf
                        <i class="fas fa-heart auth_favorite-icon" style="color:#ff69b4;"></i>
                        <input type="hidden" name="type" value="auth">
                    </form>
                    @else
                    <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form">
                        @csrf
                        <i class="far fa-heart auth_favorite-icon" style="color:#ff69b4;"></i>
                        <input type="hidden" name="type" value="auth">
                    </form>
                    @endif
                @endauth
                @guest
                    <form method="GET" action="{{ route('login') }}">
                        <button type="submit" class="btn btn-outline-secondary">login</button>
                    </form>
                    <form method="GET" action="{{ route('register') }}">
                        <button type="submit" class="btn btn-outline-secondary">register</button>
                    </form>
                    <form method="POST" action="{{ route('favorite.index') }}" class="favorite-form">
                        @csrf
                        <i class="fa-heart guest_favorite-icon" style="color:#ff69b4;"></i>
                        <input type="hidden" class="guest_favorite-input" name="favorites" value="">
                        <input type="hidden" name="type" value="guest">
                    </form>
                @endguest

                <a href="{{ route('cart.index') }}" class="fas fa-shopping-cart" style="color:black"></a>
            </div>

        </div>
    </nav>
    @yield('content')
    <div class="admin_btn" style="position: fixed; bottom: 20px; right: 20px;">
        <a href="{{ route('admin.product.index') }}" class="btn btn-success" style="color: white;">管理画面</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
<script>
    @if(session()->has('favorites'))
    localStorage.removeItem('favorites');
    @endif
    
    @guest
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    if (favorites.length > 0) {
        const guestFavoriteIcon = document.querySelector('.guest_favorite-icon');
        guestFavoriteIcon.classList.remove('far');
        guestFavoriteIcon.classList.add('fas');
    } else {
        const guestFavoriteIcon = document.querySelector('.guest_favorite-icon');
        guestFavoriteIcon.classList.remove('fas');
        guestFavoriteIcon.classList.add('far');
    }

    const guestFavoriteInput = document.querySelector('.guest_favorite-input');
    guestFavoriteInput.value = JSON.stringify(favorites);   
    @endguest

    const favoriteForm = document.querySelector('.favorite-form');
    console.log(favoriteForm);
    favoriteForm.addEventListener('click', function() {
        favoriteForm.submit();
    })

</script>