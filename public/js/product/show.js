document.addEventListener('DOMContentLoaded', function() {

    /*-----------------------------------------------
    お気に入り追加・削除の処理をログイン時・ゲスト時に分けて記載
    -------------------------------------------------*/

    let favoriteBtn = document.querySelector('.favorite button');
    if(isAuth){
        // ログインユーザー用
        if (favoriteExists) {
            favoriteBtn.textContent = 'お気に入り解除';
            favoriteBtn.classList.remove('add');
            favoriteBtn.classList.add('destroy');
            favoriteBtn.classList.add('active');
        } else {
            favoriteBtn.textContent = 'お気に入りに追加する';
            favoriteBtn.classList.add('add');
            favoriteBtn.classList.remove('active');
        }

        favoriteBtn.addEventListener('click', function() {
            let favoriteBtn = document.querySelector('.favorite button');
            if(favoriteBtn.classList[1] === 'add') {
                fetch(favoriteStoreRoute , {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('add');
                        this.classList.add('destroy');
                        this.textContent = 'お気に入り解除';
                        this.classList.add('active');
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
            }else if(favoriteBtn.classList[1] === 'destroy') {
                fetch(favoriteDestroyRoute , {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('destroy');
                        this.classList.add('add');
                        this.textContent = 'お気に入りに追加する';
                        this.classList.remove('active');
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
    } else {
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
                this.classList.remove('active');
            } else {
                // なかった場合：リストに追加
                favorites.push(itemId);
                console.log(`Item ${itemId} をお気に入りに追加しました。`);
                this.textContent = 'お気に入り解除'; // ボタンのテキストを変更
                this.classList.add('active');
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
            favoriteBtn.classList.add('active');
            const guestFavoriteInput = document.querySelector('.guest_favorite-input');
            console.log(currentFavorites);
            guestFavoriteInput.value = JSON.stringify(currentFavorites);
        } else {
            favoriteBtn.textContent = 'お気に入りに追加する';
            favoriteBtn.classList.remove('active');
            const guestFavoriteInput = document.querySelector('.guest_favorite-input');
            guestFavoriteInput.value = JSON.stringify(currentFavorites);
        }
    }

    /*-----------------------------------------------
    数量変更処理
    -------------------------------------------------*/

    const plus = document.querySelector('.plus');
    const minus = document.querySelector('.minus');

    const quantity = document.querySelector('.quantity');
    const quantityInput = document.querySelector('input[name="quantity"]');

    const productPrice = document.querySelector('.product_price');
    const productPriceText = productPrice.textContent;
    const productPriceNumber = Number(productPriceText.replace(/[^\d.-]/g, ""));

    /*プラスボタンを押したときの処理*/
    plus.addEventListener('click', function() {
        quantity.textContent++;
        quantityInput.value++;

        let price = productPriceNumber;

        let totalPrice = price * quantity.textContent; 

        productPrice.textContent = '¥' + totalPrice.toLocaleString();

    });

    /*マイナスボタンを押したときの処理*/
    minus.addEventListener('click', function() {
        if(quantity.textContent > 1) {
            quantity.textContent--;
            quantityInput.value--;

            let price = productPriceNumber;

            let totalPrice = price * quantity.textContent; 

            productPrice.textContent = '¥' + totalPrice.toLocaleString();
        };
    });

});