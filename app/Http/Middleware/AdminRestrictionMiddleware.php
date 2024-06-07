<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRestrictionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
        public function handle($request, Closure $next)
        {
            $user = auth()->user();
    
            if ($user && $user->role === 'admin') {
                abort(403, 'Администраторам запрещено выполнять это действие.');
            }
    
            return $next($request);
        }
    
}
