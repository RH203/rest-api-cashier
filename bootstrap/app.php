<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'abilities' => CheckAbilities::class,
      'ability' => CheckForAnyAbility::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (\Exception $exception, Request $request) {
      // Cek jika request berasal dari prefix /api
      if ($request->is('api/*')) {
        $statusCode = $exception instanceof HttpExceptionInterface
          ? $exception->getStatusCode()
          : 500;

        $message = $exception->getMessage() ?: 'Something went wrong';

        return response()->json([
          'status_code' => $statusCode,
          'error' => class_basename($exception),
          'message' => $message,
        ], $statusCode);
      }

      // Fallback untuk permintaan non-API
      return response()->view('errors.default', [
        'error' => class_basename($exception),
        'message' => $exception->getMessage(),
      ], 500);
    });

  })->create();
