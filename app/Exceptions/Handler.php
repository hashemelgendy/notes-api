<?php

namespace App\Exceptions;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler
{
    public static function notFound(): Closure
    {
        return function (NotFoundHttpException $e, $request) {
            $previous = $e->getPrevious();

            if ($previous instanceof ModelNotFoundException) {
                $model = class_basename($previous->getModel());

                return response()->json([
                    'status' => 'error',
                    'message' => "$model does not exist",
                ], 404);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Route not found: ' . $request->path(),
            ], 404);
        };
    }
}
