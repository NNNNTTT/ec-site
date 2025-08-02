<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name', 'laravel')}}</title>
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN（最新版） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-d8zW+...略...==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class='navbar navbar-light bg-light'>
        <div class='container'>
            <a href="{{ route('product.index') }}" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>
            <a href="{{ route('cart.index') }}" class="fas fa-shopping-cart" style="color:black"></a>
        </div>
    </nav>
    @yield('content')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>