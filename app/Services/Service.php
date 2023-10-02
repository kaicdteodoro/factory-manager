<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class Service
{
    public function response(callable $callBack): JsonResponse
    {
        try {
            $data = $callBack();
            return response()->json(['success' => $data[0], 'data' => $data[1]]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], (int)$exception->getCode() ?: 404);
        }
    }
}
