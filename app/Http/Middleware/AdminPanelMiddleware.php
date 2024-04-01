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
    public function handle(Request $request, Closure $next): Response
{
    $user = auth()->user();

    // Проверяем, является ли пользователь администратором
    if ($user->role === 'admin') {
        return $next($request);
    }

    // Получаем ID учителя из маршрута
    $teacherId = $request->route('teacher');

    // Проверяем, является ли текущий пользователь владельцем учителя с указанным ID
    if ($user->teacher && $user->teacher->id == $teacherId) {
        return $next($request);
    }

    // Если пользователь не администратор и не является владельцем учителя, перенаправляем на домашнюю страницу или другую страницу ошибки
    return redirect()->route('home')->with('error', 'Access denied.');
}
}
