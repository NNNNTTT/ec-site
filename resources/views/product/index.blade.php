<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商品一覧 | {{ config('app.name', 'Laravel')}}</title>
        <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CDN（最新版） -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-d8zW+...略...==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>
    <body>
        <nav class='navbar navbar-light bg-light'>
            <div class='container'>
                <a href="{{ route('product.index') }}" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>
                <a href="#" class="fas fa-shopping-cart" style="color:black"></a>
            </div>
        </nav>
    </body>

    <div class='jumbotron top-img'>
        <p class="text-center text-white top-img-text">{{ config('app.name', 'Laravel') }}</p>
    </div>

    <div class="container">
        <div class="top__title text-center">
            ALL Products
        </div>
        <div class='row'>
            @foreach($products as $product)
                <a href="" class="col-lg-4 col-md-6">
                    <div class="card">
                        <img src="{{ asset( $product->image )}}" alt="" class="card-img">
                        <div class="card-body">
                            <p class="card-title">{{ $product->name }}</p>
                            <p class="card-text">¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>