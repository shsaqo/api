<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthApiAuthenticateException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        try {
            parent::authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            throw new AuthApiAuthenticateException();
        }
    }
}
