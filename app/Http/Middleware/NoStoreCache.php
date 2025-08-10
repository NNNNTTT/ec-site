<?php

// app/Http/Middleware/NoStoreCache.php
namespace App\Http\Middleware;
use Closure;

class NoStoreCache {
    public function handle($request, Closure $next) {
        $res = $next($request);
        return $res
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}

