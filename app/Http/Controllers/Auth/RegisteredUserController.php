<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterToAdminMail;
use App\Mail\RegisterToUserMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        session()->forget('auth_tab');

        $phone = $request->phone;
        $phone = str_replace('-', '', $phone);

        $postal_code = $request->postal_code1 . $request->postal_code2;

        $prefecture = $this->prefecture($request->prefecture);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->register_email,
            'password' => Hash::make($request->register_password),
            'phone' => $phone,
            'postal_code' => $postal_code,
            'prefecture' => $prefecture,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ゲスト時のお気に入り情報のデータを取得する
        $favorites = $request->input('favorites_data');
        $favorites = json_decode($favorites, true);

        $user = Auth::user();

        // 管理者にメールを送信する
        Mail::to(config('mail.admin_email'))->send(new RegisterToAdminMail($user));

        // ユーザーにメールを送信する
        Mail::to($user->email)->send(new RegisterToUserMail($user));

        // ログインユーザーのお気に入り情報とゲスト時のお気に入り情報を結合する
        $user->favorites()->syncWithoutDetaching($favorites);

        // セッションにゲスト時のお気に入り情報を格納　ビュー側で受け取るため
        session(['favorites' => $favorites]);

        return redirect()->back();
    }

    protected function prefecture($prefecture)
    {
        $prefecture_rules = [
            '1' => '北海道',
            '2' => '青森県',
            '3' => '岩手県',
            '4' => '宮城県',
            '5' => '秋田県',
            '6' => '山形県',
            '7' => '福島県',
            '8' => '茨城県',
            '9' => '栃木県',
            '10' => '群馬県',
            '11' => '埼玉県',
            '12' => '千葉県',
            '13' => '東京都',
            '14' => '神奈川県',
            '15' => '新潟県',
            '16' => '富山県',
            '17' => '石川県',
            '18' => '福井県',
            '19' => '山梨県',
            '20' => '長野県',
            '21' => '岐阜県',
            '22' => '静岡県',
            '23' => '愛知県',
            '24' => '三重県',
            '25' => '滋賀県',
            '26' => '京都府',
            '27' => '大阪府',
            '28' => '兵庫県',
            '29' => '奈良県',
            '30' => '和歌山県',
            '31' => '鳥取県',
            '32' => '島根県',
            '33' => '岡山県',
            '34' => '広島県',
            '35' => '山口県',
            '36' => '徳島県',
            '37' => '香川県',
            '38' => '愛媛県',
            '39' => '高知県',
            '40' => '福岡県',
            '41' => '佐賀県',
            '42' => '長崎県',
            '43' => '熊本県',
            '44' => '大分県',
            '45' => '宮崎県',
            '46' => '鹿児島県',
            '47' => '沖縄県',
        ];

        return $prefecture_rules[$prefecture];
    }
}
