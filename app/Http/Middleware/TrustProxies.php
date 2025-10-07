<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustProxies
{
    /**
     * 信頼するプロキシ
     * Traefik 経由が前提なら '*' でOK。
     * より厳格にするなら Docker ネットワークのCIDRに置き換え（例: ['172.18.0.0/16']）。
     */
    protected $proxies = '*';

    /**
     * 参照する X-Forwarded-* ヘッダ群
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
