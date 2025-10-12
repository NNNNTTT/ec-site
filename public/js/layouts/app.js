// セッションがある場合はlocalStorageをクリア
if (hasFavoritesSession) {
    localStorage.removeItem('favorites');
}

// ゲストの場合の処理
if (isGuest) {
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

    const guestFavoriteIcon = document.querySelector('.guest_favorite-icon');
    if (favorites.length > 0) {
        guestFavoriteIcon.classList.remove('far');
        guestFavoriteIcon.classList.add('fas');
    } else {
        guestFavoriteIcon.classList.remove('fas');
        guestFavoriteIcon.classList.add('far');
    }

    const guestFavoriteInput = document.querySelector('.guest_favorite-input');
    guestFavoriteInput.value = JSON.stringify(favorites);
}

// フォーム送信
const favoriteForm = document.querySelector('.favorite-form');
if(favoriteForm) {
    favoriteForm.addEventListener('click', function() {
        favoriteForm.submit();
    });
}

// ハンバーガーメニュー
const hamburger = document.querySelector('.hamburger');
const spNav = document.querySelector('.sp-nav');
const mask = document.querySelector('.mask');
if(hamburger){
    hamburger.addEventListener('click', function(){
        hamburger.classList.toggle('active');
        spNav.classList.toggle('active');
        mask.classList.toggle('active');
    })
}
if(mask){
    mask.addEventListener('click', function(){
        hamburger.classList.remove('active');
        spNav.classList.remove('active');
        mask.classList.remove('active');
    })
}
