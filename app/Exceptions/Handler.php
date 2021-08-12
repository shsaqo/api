<?php

namespace App\Exceptions;

use App\Http\Traits\ResponseJson;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ModelNotFoundException $e) {
            return ResponseJson::response([], 404, 'Not found');
        });
        $this->renderable(function (NotFoundHttpException $e) {
            return ResponseJson::response([], 404, 'Not found');
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
