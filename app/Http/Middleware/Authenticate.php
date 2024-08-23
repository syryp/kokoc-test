<?php

namespace App\Http\Middleware;

use App\Exceptions\User\TokenExpiredException;
use App\Exceptions\User\UserNotAuthorizedException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->cookies->has('refresh_token')) {
            throw new TokenExpiredException();
        }

        throw new UserNotAuthorizedException();
    }
}
