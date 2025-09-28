<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'regex:/^0\d{1,4}-?\d{1,4}-?\d{3,4}$/'], // 電話番号の正規表現
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-?\d{4}$/'], // 郵便番号
            'prefecture' => ['required', 'string', 'max:255'], // 都道府県
            'address' => ['required', 'string', 'max:255'], // 住所
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ゲスト時のお気に入り情報のデータを取得する
        $favorites = $request->input('favorites_data');
        $favorites = json_decode($favorites, true);

        $user = Auth::user();

        // ログインユーザーのお気に入り情報とゲスト時のお気に入り情報を結合する
        $user->favorites()->syncWithoutDetaching($favorites);

        // セッションにゲスト時のお気に入り情報を格納　ビュー側で受け取るため
        session(['favorites' => $favorites]);

        return redirect()->back();
    }
}
