<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $responseData = [
            'data' => $data,
            'status' => $status,
        ];

        parent::__construct($responseData, $status, $headers, $options);
    }

    public static function success($data = null, $status = 200, $headers = [], $options = 0)
    {
        return new static($data, $status, $headers, $options);
    }

    public static function error($message = null, $status = 400, $headers = [], $options = 0)
    {
        $responseData = [
            'error' => $message,
            'status' => $status,
        ];

        return new static($responseData, $status, $headers, $options);
    }
}
