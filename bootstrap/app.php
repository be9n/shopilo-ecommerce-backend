<?php

use App\Exceptions\CanBeDeletedException;
use App\Http\Middleware\SetLocaleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            SetLocaleMiddleware::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable|Exception $exception) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => Response::HTTP_NOT_FOUND,
                        'message' => __('Not Found!'),
                        'data' => null,
                        'errors' => null,
                    ],
                    Response::HTTP_NOT_FOUND
                );
            } elseif ($exception instanceof ValidationException) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'message' => __('Data are not valid, please check the error messages'),
                        'data' => null,
                        'errors' => $exception->validator->getMessageBag()
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            } elseif ($exception instanceof AuthenticationException) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => Response::HTTP_UNAUTHORIZED,
                        'message' => __('Unauthenticated!'),
                        'data' => null,
                        'errors' => null
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            } elseif ($exception instanceof ModelNotFoundException) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => Response::HTTP_NOT_FOUND,
                        'message' => __('Model Not Found Exception!'),
                        'data' => null,
                        'errors' => null,
                    ],
                    $this->setStatusCode(Response::HTTP_NOT_FOUND)
                );
            } elseif ($exception instanceof UnauthorizedException) {
                return response(
                    [
                        'success' => false,
                        'code' => Response::HTTP_FORBIDDEN,
                        'message' => __('Forbidden!'),
                        'data' => null,
                        'errors' => null
                    ],
                    Response::HTTP_FORBIDDEN
                );
            } elseif ($exception instanceof CanBeDeletedException) {
                return response(
                    [
                        'success' => false,
                        'code' => Response::HTTP_BAD_REQUEST,
                        'message' => __('This item cannot be deleted!'),
                        'data' => null,
                        'errors' => null
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            } else {
                return response()->json(
                    [
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => __('Sorry, Something went wrong, try again later!'),
                        'success' => false,
                        'data' => null,
                        'errors' => request()->ip() == '127.0.0.1' ? $exception->getMessage() : null,
                        'trace' => request()->ip() == '127.0.0.1' ? $exception->getTrace() : null,
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        });
    })->create();
