<?php

use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptions->render(function (Throwable $e, $request) {
            $responses = new class {
                use ApiResponses;
            };

            if ($e instanceof ValidationException) {
                $errors = [];
                foreach ($e->errors() as $field => $messages) {
                    $fieldName = str($field)->afterLast('.');
                    foreach ($messages as $message) {
                        $errors[] = [
                            'status' => 422,
                            'message' => $message,
                            'source' => $fieldName
                        ];
                    }
                }

                return $responses->errorResponse($errors, 422);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'errors' => [
                        [
                            'status' => 404,
                            'message' => 'The resource cannot be found.',
                            'source' => $e->getModel()
                        ]
                    ]
                ], 404);
            }
            if($e instanceof NotFoundHttpException){
                return response()->json([
                   'errors' => [
                       [
                           'status' => 404,
                           'message' => 'The resource cannot be found.',
                           'type'=> 'NotFoundHttpException'
                       ]
                   ]
                ]);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'errors' => [
                        [
                            'status' => 401,
                            'message' => 'Unauthenticated',
                            'source' =>  'Line: ' . $e->getLine() . ': ' . $e->getFile()
                        ]
                    ]
                ], 401);
            }

            return response()->json([
                'errors' => [
                    [
                        'status' => 500,
                        'message' => 'An unexpected error occurred.',
                        'type' => class_basename($e)
                    ]
                ]
            ], 500);
        });
    })->create();
