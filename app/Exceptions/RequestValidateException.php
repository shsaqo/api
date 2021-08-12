<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class RequestValidateException extends Exception
{
    public $error;
    public function __construct($error, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->error = $error;
    }

    public function render($request)
    {
        return response()->json( [
            'message' => $this->error,
            'status' => 400,
            'data' => []
        ], 400);
    }
}
