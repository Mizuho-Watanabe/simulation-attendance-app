<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * 管理者チェック
     */
    public function handle(Request $request, Closure $next)
    {
        $user =Auth::user();
        
        if (! $user || $user->admin_status !== '管理者') {
            abort(403, '管理者権限がありません');
        }

        return $next($request);
    }
}
