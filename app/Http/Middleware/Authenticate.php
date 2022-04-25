<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!Auth::guard('api')->check()) {
            return ResponseFormatter::error(null, 'Unauthorized', 401);
        }
        if (!$request->expectsJson()) {
            return route('login');
        }
        if ($request->expectsJson()) {
            return ResponseFormatter::error(null, 'Unauthorized', 401);
        }
    }
}
