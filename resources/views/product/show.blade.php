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
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="product__quantity">
                <input type="number" name='quantity' min='1' value='1' require>
            </div>
            <div class="product__btn-add-cart">
                <button type='submit' class='btn btn-outline-secondary'>カートに追加する</button>
            </div>
            <div class="favorite mb-3">
                <button type="button" class="btn btn-outline-danger" data-item-id="{{ $product->id }}">お気に入りに追加する</button>
            </div>
            <a href="{{ route('product.index') }}">TOPへ戻る</a>
        </form>
    </div>
</div>

<script>
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

</script>
@endsection
