<?php

namespace App\Http\Middleware;

use Closure;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->checkSession()) {
            return redirect(route('login'));
        }
        return $next($request);
    }

    /**
     * Check session's state
     * @return bool
     */
    private function checkSession()
    {
        $auth = \Session::get('auth_token');
        return (bool)$auth;
    }
}
