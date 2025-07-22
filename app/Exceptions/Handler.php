<?php

namespace App\Exceptions;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public static function render(): Closure
    {
        return function (Throwable $e, Request $request): ?JsonResponse {
            $previous = method_exists($e, 'getPrevious') ? $e->getPrevious() : null;

            return match (true) {
                $previous instanceof ModelNotFoundException => self::handleModelNotFound($previous),
                $e instanceof NotFoundHttpException => self::handleRouteNotFound($e, $request),
                $e instanceof AuthenticationException => self::handleUnauthenticated($e),
                $e instanceof AuthorizationException,
                $e instanceof AccessDeniedHttpException => self::handleForbidden($e),
                default => null,
            };
        };
    }

    private static function handleModelNotFound(ModelNotFoundException $e): JsonResponse
    {
        $model = class_basename($e->getModel());

        return response()->json([
            'status' => 'error',
            'message' => "$model not found",
        ], 404);
    }

    private static function handleRouteNotFound(NotFoundHttpException $e, Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Route not found: '.$request->path(),
        ], 404);
    }

    private static function handleUnauthenticated(AuthenticationException $e): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated',
        ], 401);
    }

    private static function handleForbidden(AuthorizationException|AccessDeniedHttpException $e): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'You do not have permission to access this resource',
        ], 403);
    }
}
