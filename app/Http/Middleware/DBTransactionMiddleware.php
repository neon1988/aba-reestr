<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DBTransactionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return DB::transaction(function () use ($next, $request) {
            return $next($request);
        });
    }
}

