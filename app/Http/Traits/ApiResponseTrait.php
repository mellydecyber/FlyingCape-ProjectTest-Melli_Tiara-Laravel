<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

trait ApiResponseTrait
{
    /**
     * @param  mixed  $data
     * @param  array  $metadata
     * @param  int  $code
     * @param  array  $headers
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function sendSuccess(
        mixed $data,
        array $metadata,
        int $code = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return response()->json(
            [
                'status' => true,
                'data' => $data,
                'metadata' => $metadata,
            ],
            $code,
            $headers
        );
    }

    /**
     * @param  mixed  $data
     * @param  array  $metadata
     * @param  int  $code
     * @param  array  $headers
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function sendError(
        string $message,
        ?Throwable $exception = null,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = []
    ): JsonResponse {
        $response = ['message' => $message];

        if (!is_null($exception) && config('app.debug')) {
            $response['debug'] = [
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTraceAsString()
            ];
        }

        return response()->json($response, $code, $headers);
    }
}
