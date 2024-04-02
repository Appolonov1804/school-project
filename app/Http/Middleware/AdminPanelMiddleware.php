<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Проверяем, является ли пользователь администратором
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Проверяем, является ли путь страницей учителей
        if ($request->is('admin/teacher*')) {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        // Если пользователь не администратор и не заходит на страницу учителей, позволяем ему продолжить запрос
        return $next($request);
    }
}
