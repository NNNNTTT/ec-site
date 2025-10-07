<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Traefik 経由なら '*' でもOK。
     * もっと厳密にするなら Docker ネットワークのCIDRに置き換え:
     * 例) protected $proxies = ['172.18.0.0/16'];
     */
    protected $proxies = '*';

    /**
     * X-Forwarded-* ヘッダ群を使用
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
