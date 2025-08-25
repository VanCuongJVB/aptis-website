<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAccessWindow
{
    public function handle(Request $request, Closure $next)
    {
        $u = Auth::user();
        if (!$u) return redirect()->route('login');

        $now = now();
        if (!$u->is_admin) {
            if (!$u->is_active) {
                return response()->view('access.denied', ['reason' => 'Tài khoản bị tắt'], 403);
            }
            if ($u->access_starts_at && $now->lt($u->access_starts_at)) {
                return response()->view('access.denied', ['reason' => 'Chưa đến thời gian truy cập'], 403);
            }
            if ($u->access_ends_at && $now->gt($u->access_ends_at)) {
                return response()->view('access.denied', ['reason' => 'Hết thời gian truy cập'], 403);
            }
        }
        return $next($request);
    }
}
