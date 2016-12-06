<?php
namespace App\Http\Middleware;
use Auth;
use Closure;
class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin) {
            return $next($request);
        }
        return redirect()->route('post.index');
    }
}