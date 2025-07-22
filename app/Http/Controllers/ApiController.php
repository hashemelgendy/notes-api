<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

abstract class ApiController extends Controller
{
    use AuthorizesRequests;

    /**
     * Success Response
     */
    protected function success(array $data = [], int $status = 200): JsonResponse
    {
        return ApiResponse::success($data, $status);
    }

    /**
     * Error Response
     */
    protected function error(string $message, int $status = 400): JsonResponse
    {
        return ApiResponse::error($message, $status);
    }
}
