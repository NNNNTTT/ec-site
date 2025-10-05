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
}
