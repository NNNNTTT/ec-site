@extends('layouts.admin')

@section('title')
    月毎売上一覧
@endsection

@section('content')

    <div class="card-body">
        <form action="{{ route('admin.sale.month_search') }}" method="POST" class="d-flex justify-content-end gap-2 mb-3 align-items-center"> 
            @csrf
            <div class="form-group">
                <label for="year">年を選択:</label>
                <select id="year" name="year">
                    @for ($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-outline-secondary" style="width: 100px; height: 40px;">検索</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>年月</th>
                    <th>注文数</th>
                    <th>売上</th>
                </tr>
            </thead>
            @foreach($sales as $month => $sale)
            <tbody>
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $sale['order_count'] }}</td>
                    <td>{{ $sale['total_price'] }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
@endsection