<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Openapi\Attributes\Info;
use App\Openapi\Attributes\SecurityHttp;
use Illuminate\Http\JsonResponse;

#[Info('MyFD API', '1')]
#[SecurityHttp('auth', 'Авторизация на основе Bearer токена')]
class BaseApiController extends Controller
{
    /**
     * Возвращает положительный ответ
     *
     * @param array $data
     * @param int   $status
     * @param array $headers
     * @return JsonResponse
     */
    public function successResponse(array $data, int $status = 200, array $headers = []): JsonResponse
    {
        return response()->json(['status' => 'ok', 'data' => $data], $status, $headers);
    }

    /**
     * Возвращает ответ с ошибкой
     *
     * @param string $message
     * @param int    $status
     * @param array  $data
     * @param array  $headers
     * @return JsonResponse
     */
    public function errorResponse(string $message, int $status, array $data = [], array $headers = []): JsonResponse
    {
        return response()->json(['status' => 'error', 'message' => $message, 'data' => $data], $status, $headers);
    }
}
