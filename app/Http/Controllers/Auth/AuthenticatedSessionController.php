<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\LineItemController;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('order.auth');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {   
        // ゲスト時のお気に入り情報のデータを取得する
        $favorites = $request->input('favorites_data');
        $favorites = json_decode($favorites, true);

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // ログインユーザーのお気に入り情報とゲスト時のお気に入り情報を結合する
        $user->favorites()->syncWithoutDetaching($favorites);

        // セッションにゲスト時のお気に入り情報を格納　ビュー側で受け取るため
        session(['favorites' => $favorites]);

        return redirect()->back();
    }   

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
