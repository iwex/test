<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->checkCredentials($request)) {
            return response('Unauthorized.', 401);
        }
        
        return $next($request);
    }
    
    /**
     * Check login and password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    protected function checkCredentials($request)
    {
        return ($request->getUser() === config('receiver.auth_username')) &&
               ($request->getPassword() === config('receiver.auth_password'));
    }
}
