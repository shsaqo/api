<?php

namespace App\Exceptions;

use Exception;

class AuthApiAuthenticateException extends Exception
{
    public function render($request)
    {
        return response()->json( [
            'message' => 'Unauthenticated',
            'code' => 401,
        ], 401);
    }
}
