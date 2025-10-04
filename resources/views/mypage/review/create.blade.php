@extends('layouts.app')

@section('title', '商品レビューを書く')

@section('content')
<div class="container">
    <h2 class="mb-5 mt-5">商品レビューを書く</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mypage.review.store') }}" method="post">
                @csrf
                <div class="py-3 border-bottom mb-3">
                    <div class="order_img">
                        <img src="{{ asset($product->image) }}" alt="注文商品画像" width="100">
                    </div>
                    
                    <div class="order_info mt-3">
                        <p class="card-text">{{ $product->name }}</p>
                    </div>
                </div>
                <div class="mb-3" style="max-width: 100px;">
                    <label for="exampleFormControlInput1" class="form-label">レビュー</label>
                    <select class="form-select" name="rating" id="exampleFormControlInput1" >
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                    @if($errors->has('rating'))
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first('rating') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3" style="max-width: 700px;">
                    <label for="exampleFormControlTextarea1" class="form-label">タイトル</label>
                    <input type="text" class="form-control" name='title' id="exampleFormControlTextarea1" rows="3" ></input>
                    @if($errors->has('title'))
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3" style="max-width: 700px;">
                    <label for="exampleFormControlTextarea1" class="form-label">レビュー内容</label>
                    <textarea class="form-control" name='comment' id="exampleFormControlTextarea1" rows="3"></textarea>
                    @if($errors->has('comment'))
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first('comment') }}
                        </div>
                    @endif
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="order_id" value="{{ $order_id }}">
                <button type="submit" class="btn btn-outline-secondary">登録</button>
            </form>
        </div>
    </div>
    
</div>
@endsection