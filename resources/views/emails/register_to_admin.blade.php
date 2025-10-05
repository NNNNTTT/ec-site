<p>
    {{ $user->name }}さんが会員登録しました。<br><br>

    お名前：{{ $user->name }}<br>
    メールアドレス：{{ $user->email }}<br>
    電話番号：{{ $user->phone }}<br>
    郵便番号：{{ $user->postal_code }}<br>
    ご住所：{{ $user->prefecture }}{{ $user->address }}<br>
</p>