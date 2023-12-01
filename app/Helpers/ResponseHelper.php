<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function jsonResponse($status, $message = null, $data, $error = null)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'error' => $error,
        ], $status);
    }
}
