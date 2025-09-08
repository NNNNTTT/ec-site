@extends('layouts.app')

@section('title')
{{ $product->name }}
@endsection

@section('content')
<div class="container">
    <div class="product">
        <img src="{{ asset($product->image) }}" alt="" class="product-img">
        <div class="product__content-header text-center">
            <div class="product__name">
                {{ $product->name }}
            </div>
            <div class="product__price">
                ¥{{ number_format($product->price )}}
            </div>
        </div>
        {{ $product->description }}
        <form method='POST' action="{{ route('line_item.create') }}">
            @csrf
            @if($product->stock <= 0)
                <p class="product__stock mt-3 text-danger">
                    こちらの商品は現在在庫切れのため購入できません。
                </p>
            @else
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="product__quantity">
                <input type="number" name='quantity' min='1' value='1' require>
            </div>
            <div class="product__btn-add-cart">
                <button type='submit' class='btn btn-outline-secondary'>カートに追加する</button>
            </div>
            @endif
            <div class="favorite mb-3">
                <button type="button" class="btn btn-outline-danger" data-item-id="{{ $product->id }}">お気に入りに追加する</button>
            </div>
            <a href="{{ route('product.index') }}">TOPへ戻る</a>
        </form>
    </div>
    <div class="review mt-5 text-left">
        <p class="border-bottom p-3">レビュー</p>
        @foreach ($product->reviews as $review)
        <div class="review-item border-bottom">
            <div class="text-warning mb-1">
                {{ str_repeat('★', $review->pivot->rating) }}
                {{ str_repeat('☆', 5 - $review->pivot->rating) }}
            </div>
            <p class="fw-bold mb-1">{{ $review->pivot->title }}</p>
            <p>{{ $review->pivot->comment }}</p>
            @if (Auth::check())
                @if (Auth::user()->id === $review->pivot->user_id)
                    <a href="{{ route('mypage.review.edit', $review->pivot->id) }}" class="btn btn-outline-secondary mb-3">レビューを編集する</a>
                @endif
            @endif
            <div class="d-flex justify-content-between">
                <p style="font-size: 12px; color: #6c757d;">{{ $review->pivot->created_at->format('Y/m/d H:i') }}</p>
                <p style="color: #6c757d;">不適切なレビューを報告する</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    @if (Auth::check())
    document.addEventListener('DOMContentLoaded', function() {
        let favoriteBtn = document.querySelector('.favorite button');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        @if ($product->favorites()->where('user_id', Auth::id())->exists())
            favoriteBtn.textContent = 'お気に入り解除';
            favoriteBtn.classList.remove('add');
            favoriteBtn.classList.add('destroy');
        @else
            favoriteBtn.textContent = 'お気に入りに追加する';
            favoriteBtn.classList.add('add');
        @endif
        favoriteBtn.addEventListener('click', function() {
            let favoriteBtn = document.querySelector('.favorite button');
            if(favoriteBtn.classList[2] === 'add') {
                fetch('{{ route('favorite.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id }},
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('add');
                        this.classList.add('destroy');
                        this.textContent = 'お気に入り解除';
                        const authFavoriteIcon = document.querySelector('.auth_favorite-icon');
                        console.log(authFavoriteIcon);
                        if(authFavoriteIcon.classList.contains('far')) {
                            authFavoriteIcon.classList.remove('far');
                            authFavoriteIcon.classList.add('fas');
                        }
                    } else {
                        console.log('お気に入りに追加できませんでした。');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }else if(favoriteBtn.classList[2] === 'destroy') {
            fetch('{{ route('favorite.destroy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.remove('destroy');
                    this.classList.add('add');
                    this.textContent = 'お気に入りに追加する';
                } else {
                    console.log('お気に入りを解除できませんでした。');
                }
                if(data.favoritecount === 0) {
                    const guestFavoriteIcon = document.querySelector('.auth_favorite-icon');
                    guestFavoriteIcon.classList.remove('fas');
                    guestFavoriteIcon.classList.add('far');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
    });
    @else
    document.addEventListener('DOMContentLoaded', function() {
        const favoriteBtn = document.querySelector('.favorite button');
        const itemId = favoriteBtn.getAttribute('data-item-id');
        favoriteBtn.addEventListener('click', function() {

            // 1. 現在のLocalStorageからお気に入りリストを取得
            // データがなければ空の配列 '[]' を使う
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

            // 2. 既にお気に入り登録されているかチェック
            const itemIndex = favorites.indexOf(itemId);
            
            if (itemIndex > -1) {
                // あった場合：リストから削除
                favorites.splice(itemIndex, 1);
                console.log(`Item ${itemId} をお気に入りから削除しました。`);
                this.textContent = 'お気に入りに追加する'; // ボタンのテキストを戻す
            } else {
                // なかった場合：リストに追加
                favorites.push(itemId);
                console.log(`Item ${itemId} をお気に入りに追加しました。`);
                this.textContent = 'お気に入り解除'; // ボタンのテキストを変更
            }

            if(favorites.length > 0) {
                const guestFavoriteIcon = document.querySelector('.guest_favorite-icon');
                guestFavoriteIcon.classList.remove('far');
                guestFavoriteIcon.classList.add('fas');
            } else {
                const guestFavoriteIcon = document.querySelector('.guest_favorite-icon');
                guestFavoriteIcon.classList.remove('fas');
                guestFavoriteIcon.classList.add('far');
            }

            // 3. 更新したリストをJSON文字列に変換してLocalStorageに保存
            localStorage.setItem('favorites', JSON.stringify(favorites));
            const guestFavoriteInput = document.querySelector('.guest_favorite-input');
            guestFavoriteInput.value = JSON.stringify(favorites);

            // 確認用：現在のリストをコンソールに出力
            console.log('現在のお気に入りリスト:', localStorage.getItem('favorites'));
        })
        // --- ページ読み込み時に、既にお気に入りのボタンの表示を更新する処理 ---
        const currentFavorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        if (currentFavorites.includes(itemId)) {
            favoriteBtn.textContent = 'お気に入り解除';
            const guestFavoriteInput = document.querySelector('.guest_favorite-input');
            console.log(currentFavorites);
            guestFavoriteInput.value = JSON.stringify(currentFavorites);
        } else {
            favoriteBtn.textContent = 'お気に入りに追加する';
            const guestFavoriteInput = document.querySelector('.guest_favorite-input');
            guestFavoriteInput.value = JSON.stringify(currentFavorites);
        }
    })
    @endif
</script>
@endsection
