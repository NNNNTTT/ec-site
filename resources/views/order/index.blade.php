@extends('layouts.app')

@section('title')
    ご注文手続き
@endsection

@section('css', asset('css/order/index.css'))

@section('content')
<script src="https://js.stripe.com/v3/"></script>
<div class="container my-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1 class="text-center mb-4">ご注文手続き</h1>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="h5 mb-0">ご注文内容</h2>
                </div>
                @if($price_count == 0)
                    <div class="card-body">
                        @foreach($line_items as $line_item)
                            @if($line_item->stock <= 0)
                                <p class="text-danger">{{ $line_item->name }}は現在在庫切れのため購入できません。</p>
                            @endif
                        @endforeach
                        <a class="btn btn-outline-secondary" href="{{ route('product.index') }}">商品一覧へ戻る</a>
                    </div>
                @else
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="">
                                    <tr>
                                        <th scope="col">商品名</th>
                                        <th scope="col" class="text-end">価格</th>
                                        <th scope="col" class="text-end">数量</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($line_items as $line_item)
                                        @if($line_item->stock <= 0)
                                            <p class="text-danger">{{ $line_item->name }}は現在在庫切れのため購入できません。</p>
                                        @else
                                        <tr>
                                            <td>{{ $line_item->name }}</td>
                                            <td class="text-end">¥{{ number_format($line_item->price) }}</td>
                                            <td class="text-end">{{ $line_item->pivot->quantity }}</td>
                                            <input type="hidden" name="line_items[{{ $loop->index }}][product_id]" value="{{ $line_item->id }}">
                                            <input type="hidden" name="line_items[{{ $loop->index }}][quantity]" value="{{ $line_item->pivot->quantity }}">
                                            <input type="hidden" name="line_items[{{ $loop->index }}][price]" value="{{ $line_item->price }}">
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="2" class="text-end fs-5">小計</td>
                                        <td class="text-end fs-5">¥{{ number_format($subtotal) }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2" class="text-end fs-5">送料</td>
                                        <td class="text-end fs-5">¥{{ number_format($shipping_fee) }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2" class="text-end fs-5">合計金額</td>
                                        <td class="text-end fs-5">¥{{ number_format($total_price) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="h5 mb-0">お届け先情報</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">お名前</dt>
                            <dd class="col-sm-9">{{ $user->name }}</dd>

                            <dt class="col-sm-3">メールアドレス</dt>
                            <dd class="col-sm-9">{{ $user->email }}</dd>

                            <dt class="col-sm-3">電話番号</dt>
                            <dd class="col-sm-9">{{ $user->phone }}</dd>

                            <dt class="col-sm-3">郵便番号</dt>
                            <dd class="col-sm-9">〒{{ $user->postal_code }}</dd>

                            <dt class="col-sm-3">ご住所</dt>
                            <dd class="col-sm-9">{{ $user->prefecture }}{{ $user->address }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0">お支払い方法</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 mb-3">お支払方法</dt>
                            <dd class="col-sm-9">
                                <input type="radio" id="radio_card" name="payment_method" value="credit_card">
                                <label for="credit_card" class='me-3'>クレジットカード</label>
                                <input type="radio" id="radio_cash_on_delivery" name="payment_method" value="cash_on_delivery">
                                <label for="cash_on_delivery" class='me-3'>代引き</label>
                                <input type="radio" id="radio_bank_transfer" name="payment_method" value="bank_transfer">
                                <label for="bank_transfer" class='me-3'>銀行振込</label>
                            </dd>

                            <dt class="col-sm-3 card-btn-title" style="display: none;">クレジットカード登録</dt>
                            <dd class="col-sm-9 card-btn" style="display: none;">
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" id="card_btn">
                                登録
                            </button>
                                <p class="card-message"></p>
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="order_btn" id='order_btn' disabled>注文を確定する</button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg">カートに戻る</a>
                </div>
                <input type="hidden" name="shipping_fee" value="{{ $shipping_fee }}">
                <input type="hidden" name="total_price" value="{{ $total_price }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="user_name" value="{{ $user->name }}">
                <input type="hidden" name="user_email" value="{{ $user->email }}">
                <input type="hidden" name="user_phone" value="{{ $user->phone }}">
                <input type="hidden" name="user_postal_code" value="{{ $user->postal_code }}">
                <input type="hidden" name="user_prefecture" value="{{ $user->prefecture }}">
                <input type="hidden" name="user_address" value="{{ $user->address }}">
                <input type="hidden" name="customer_id" value="">
                <input type="hidden" name="payment_method_id" value="">
            </form>
            @endif

        </div>
    </div>
</div>

<!-- クレジットカード入力画面（モーダル表示） -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">クレジットカード登録</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- クレジットカード入力フォーム -->
                <form action="" method="POST" id="card-form">
                    <div class="card-form">
                        <div id="card-element">
                            <div id="card-number" class='form-control form-control-lg mb-3'></div>
                            <div id="card-expiry" class='form-control form-control-lg mb-3'></div>
                            <div id="card-cvc" class='form-control form-control-lg mb-3'></div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer flex-column">
                <button type="submit" id="card-submit" class="btn btn-dark btn-lg">登録</button>
                <p id="error-message" class="text-danger"></p>
            </div>
        </div>
    </div>
</div>

<script>
    const orderCardRoute = @json(route('order.card'));
    const stripePublicKey = @json(config('services.stripe.public_key'));
</script>

@endsection

@section('js', asset('js/order/index.js'))