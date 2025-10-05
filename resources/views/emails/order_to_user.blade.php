<p>
    {{ $order->user->name }}様<br><br>

    ご注文ありがとうございました。<br>
    以下の情報で注文を承りました。<br>

    [注文情報]<br>
    注文番号：{{ $order->id }}<br>
    注文日時：{{ $order->created_at }}<br>
    
    @foreach($order->products as $product)
    商品名：{{ $product->name }}　　　　購入数：{{ $product->pivot->quantity }}<br>
    @endforeach

    合計金額：{{ $order->total_price }}<br>
    支払い情報：
    @if($order->payment_method == 'credit_card')
        クレジットカード
    @elseif($order->payment_method == 'bank_transfer')
        銀行振込
    @elseif($order->payment_method == 'cash_on_delivery')
        代引き
    @endif
    <br><br>

    [注文者情報]<br>
    注文者ID：{{ $order->user->id }}<br>
    お名前：{{ $order->user->name }}様<br><br>
    
    [お届け先情報]<br>
    お名前：{{ $order->shipping_name }}様<br>
    郵便番号：{{ $order->shipping_postcode }}<br>
    ご住所：{{ $order->shipping_prefecture }}{{ $order->shipping_address }}<br>
    電話番号：{{ $order->shipping_phone }}<br>

</p>