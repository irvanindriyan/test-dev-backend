<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\FunctionHelpers;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $throwable) {
            if (request()->is('api/*')) {
                $getStatusCode = $response->getStatusCode();

                switch ($getStatusCode) {
                    case 500:
                            return FunctionHelpers::resError(
                                    $throwable->getMessage(), 
                                    $getStatusCode
                                );
                        break;
                    
                    default:
                            return response()->json(
                                FunctionHelpers::resError(
                                    $throwable->getMessage(), 
                                    $getStatusCode
                                ), 
                                $getStatusCode
                            );
                        break;
                }
            }

            return $response;
        });
    })->create();
