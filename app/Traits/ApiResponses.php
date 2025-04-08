<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses {
    public function ok($message, $data = []): JsonResponse
    {
        return $this->successResponse($message, $data, 200);
    }
    public function successResponse($message, $data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    public function errorResponse($errors = [], $statusCode = null): JsonResponse
    {
        if (is_string($errors)) {
            return response()->json([
                'message' => $errors,
                'status' => $statusCode
            ], $statusCode);
        }

        return response()->json([
            'errors' => $errors
        ]);
    }

    public function unauthorized($message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse([
            'status' => 401,
            'message' => $message,
        ]);
    }
}
