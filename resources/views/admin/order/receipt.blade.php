{{-- resources/views/pdf/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>領収書</title>
    <style>
        * {
            font-family: ipaexg, sans-serif;
            font-style: normal;
            font-weight: normal;
        }
        body {
            margin: 40px;
            font-size: 13px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-family: ipaexg, sans-serif;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .company-info {
            text-align: right;
            font-size: 12px;
            line-height: 1.5;
        }
        .section {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: center;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            font-family: ipaexg, sans-serif;
            background-color: #f4f4f4;
        }
        .total {
            width: 100%;
        }
        .total table {
            width: 50%;
            margin-left: auto ;
        }
        .total-label {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: right;
            margin-top: 40px;
            font-size: 12px;
        }
        .footer p{
            margin: 0;
        }
        .shipping-info p{
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>領収書</h1>
    </div>

    <div class="section">
        <p>発行日：{{ now()->format('Y-m-d') }}</p>
        <div class="shipping-info">
            <p>注文番号：{{ $order->id }}</p>
            <p>{{ $order->shipping_name}}様</p>
            <p>〒{{ $order->shipping_postcode }}</p>
            <p>{{ $order->shipping_prefecture }}{{ $order->shipping_address }}</p>
        </div>
        <p>下記の通り、商品代金を領収いたしました。</p>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>単価（税込）</th>
                    <th>金額（税込）</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>¥{{ number_format($product->pivot->price) }}</td>
                        <td>¥{{ number_format($product->pivot->price * $product->pivot->quantity) }}</td>
                    </tr>
                    @php
                        $subtotal += $product->pivot->price * $product->pivot->quantity;
                    @endphp
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <table>
                <tbody>
                    <tr>
                        <td class="total-label">小計</td>
                        <td>¥{{ number_format($subtotal) }}</td>
                    </tr>
                    <tr>
                        <td class="total-label">送料</td>
                        <td>¥{{ number_format($order->shipping_fee) }}</td>
                    </tr>
                    <tr>
                        <td class="total-label">合計（税込）</td>
                        <td>¥{{ number_format($order->total_price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="footer">
        <p>発行元：{{ config('app.name', 'Laravel') }} ECサイト</p>
        <p>住所：福岡県福岡市〇〇1-2-3</p>
        <p>電話番号：092-1234-5678</p>
    </div>
</body>
</html>
