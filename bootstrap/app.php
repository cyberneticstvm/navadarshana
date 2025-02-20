<?php

use App\Http\Middleware\ValidateRequest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ValidateRequest::class);
        $middleware->alias([
            'branch' => \App\Http\Middleware\Branch::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (UnauthorizedException $e) {
            return response()->view('error', ['exception' => $e]);
        });
        $exceptions->renderable(function (NotFoundHttpException $e) {
            return redirect()->back()->with('error', 'Requested record not found / deleted!');
        });
        $exceptions->renderable(function (ErrorException $e) {
            return response()->view('error', ['exception' => $e]);
        });
    })->create();
