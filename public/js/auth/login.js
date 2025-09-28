/*-----------------------------------------------------
ローカルストレージのお気に入り情報をフォーム送信に加えるための処理
ゲスト時のお気に入り情報をログイン時にも保持させるため
-----------------------------------------------------*/

// LocalStorageからお気に入り情報を取得
let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

// 複数のinputを取得
const favoriteInputs = document.querySelectorAll('input[name="favorites_data"]');

// ログインと会員登録どちらにも値をセットする
for (let i = 0; i < favoriteInputs.length; i++) {
    favoriteInputs[i].value = JSON.stringify(favorites);
}
