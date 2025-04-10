<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ResponseFormatter
{
    protected static $response = [];

    /**
     * Give success response.
     */
    public static function success($data = null, $pagging = null)
    {
        self::$response['data'] = $data;

        if ($pagging) {
            self::$response['pagging'] = $pagging;
        }

        return response()->json(self::$response, Response::HTTP_OK);
    }

    /**
     * Give error response.
     */
    public static function error($errors = null, $code = Response::HTTP_BAD_REQUEST)
    {
        self::$response['errors'] = $errors;

        return response()->json(self::$response, $code);
    }
}
