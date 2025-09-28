// ローカルストレージのお気に入り情報をフォーム送信に加えるための処理
// ゲスト時のお気に入り情報をログイン時にも保持させるため

let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
const favoriteInput = document.querySelector('input[name="favorites"]');
favoriteInput.value = JSON.stringify(favorites);