<?php

namespace App\Http\Middleware;

use App\Exceptions\User\NeedTwoFactorAuthException;
use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class TwoFactorAuthenticator extends Middleware
{
    public function handle($request, Closure $next)
    {
        $authenticator = app(Authenticator::class)->bootStateless($request);

        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        new NeedTwoFactorAuthException();
    }
}
