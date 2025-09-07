@extends('layouts.admin')

@section('title')
    日毎売上一覧
@endsection

@section('content')

    <div class="card-body">
        <form action="{{ route('admin.sale.days_search') }}" method="POST" class="d-flex justify-content-end gap-2 mb-3"> 
            @csrf
            <div class="form-group" style="width: 200px;">
                <label for="start_date">開始日</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group" style="width: 200px;">
                <label for="end_date">終了日</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-secondary" style="width: 100px; height: 40px;">検索</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>年月日</th>
                    <th>注文数</th>
                    <th>売上</th>
                </tr>
            </thead>
            @foreach($sales as $date => $sale)
            <tbody>
                <tr>
                    <td>{{ $date }}</td>
                    <td>{{ $sale['order_count'] }}</td>
                    <td>{{ $sale['total_price'] }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
@endsection