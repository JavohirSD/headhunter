<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success response template
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public function success(mixed $data, string $message = "", int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }


    /**
     * Success response template
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public function error(mixed $data, string $message = "", int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
