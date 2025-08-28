<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\LineItemService;

class MergeGuestCartOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // 'Login'イベントが発生したら、このhandleメソッドが自動的に呼ばれる
    public function handle(Login $event)
    {
        // ログイン処理の「裏側」で、静かにカートのマージ処理を実行する
        $lineItemService = new LineItemService();
        $lineItemService->marge(); // $event->userにはログインしたユーザー情報が入っている
    }
}
