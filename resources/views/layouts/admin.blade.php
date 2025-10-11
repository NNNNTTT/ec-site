<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>@yield('title') | {{ config('app.name', 'laravel')}}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebars.css') }}">
</head>

<body>
    <div class="d-flex">
        <div class="flex-shrink-0 p-3" style="width: 280px; height: 100vh; position: fixed; top: 0; left: 0; background-color: #f8f9fa;">
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
            <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-5 fw-semibold">管理画面</span>
            </a>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#product-collapse" aria-expanded="false">
                    商品
                    </button>
                    <div class="collapse" id="product-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('admin.product.index') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">商品一覧</a></li>
                        <li><a href="{{ route('admin.product.create') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">商品登録</a></li>
                        <li><a href="{{ route('admin.product_category.index') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">商品カテゴリー一覧</a></li>
                        <li><a href="{{ route('admin.product_category.create') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">商品カテゴリー登録</a></li>
                        <li><a href="{{ route('admin.product.stock_edit') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">在庫編集</a></li>
                    </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#order-collapse" aria-expanded="false">
                        注文管理
                    </button>
                    <div class="collapse" id="order-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('admin.order.index') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">注文一覧</a></li>
                    </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#sales-collapse" aria-expanded="false">
                        売上管理
                    </button>
                    <div class="collapse" id="sales-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('admin.sale.days_show') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">日毎売上一覧</a></li>
                        <li><a href="{{ route('admin.sale.month_show') }}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">月毎売上一覧</a></li>
                    </ul>
                    </div>
                </li>
                <!--
                <li class="border-top my-3"></li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    Account
                    </button>
                    <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">New...</a></li>
                        <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Profile</a></li>
                        <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Settings</a></li>
                        <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Sign out</a></li>
                    </ul>
                    </div>
                </li> -->
            </ul>
        </div>
        <div class="container" style="margin-left: 280px;">
            <h2 class="py-3 px-3 mb-4 mt-4" style="border-left: 10px solid #ccc;">@yield('title')</h2>
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jsファイルに渡すデータ -->
    <div id="show" data-show="{{ $show }}"></div>
    
    <script src="{{ asset('js/sidebars.js') }}"></script>
    <script src="{{ asset('js/layouts/admin.js') }}"></script>
    <script src="@yield('js')"></script>
</body>
</html>