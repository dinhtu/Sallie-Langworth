<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login' . '?url_redirect='. url()->full());
        }
        return $next($request);
    }
}
