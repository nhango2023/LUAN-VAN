<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanAcessAdminPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập và có level 'admin' chưa
        if (auth()->check() && auth()->user()->level === 'admin') {
            return $next($request);
        }

        // Nếu không, trả về lỗi 403 Unauthorized
        abort(403, 'Unauthorized');
    }
}
