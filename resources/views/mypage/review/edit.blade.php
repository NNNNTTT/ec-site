@extends('layouts.app')

@section('title', 'レビュー編集')

@section('content')
<div class="container">
    <h2 class="mb-5 mt-5">商品レビューを書く</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mypage.review.update', [$order_id, $review->id]) }}" method="post">
                @csrf
                <div class="py-3 border-bottom mb-3">
                    <div class="order_img">
                        <img src="{{ asset($product->image) }}" alt="注文商品画像" width="100">
                    </div>
                    
                    <div class="order_info mt-3">
                        <p class="card-text">{{ $product->name }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">レビュー</label>
                    <select class="form-select" name="rating" id="exampleFormControlInput1" style="max-width: 700px;">
                        <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">タイトル</label>
                    <input type="text" class="form-control" name='title' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;" value="{{ $review->title }}"></input>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">レビュー内容</label>
                    <textarea class="form-control" name='comment' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;">{{ $review->comment }}</textarea>
                </div>
                <button type="submit" class="btn btn-outline-secondary">更新</button>
            </form>
        </div>
    </div>
    
</div>
@endsection