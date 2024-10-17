<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Inertia\Inertia;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


public function render($request, Throwable $exception)
{
    if ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
        return Inertia::render('Errors/403');
    }
    if ($exception instanceof HttpException && $exception->getStatusCode() === 404) {
        return Inertia::render('Errors/404');
    }
    return parent::render($request, $exception);
}

}
