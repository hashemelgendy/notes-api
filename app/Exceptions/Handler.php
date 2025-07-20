<?php

namespace App\Exceptions;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler
{
    public static function notFound(): Closure
    {
        return function (NotFoundHttpException $e, $request) {
            $previous = $e->getPrevious();

            if ($previous instanceof ModelNotFoundException) {
                return self::handleModelNotFound($previous);
            }

            return self::handleRouteNotFound($e, $request);
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

    private static function handleRouteNotFound(NotFoundHttpException $e, $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Route not found: ' . $request->path(),
        ], 404);
    }
}
