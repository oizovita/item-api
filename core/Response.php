<?php

namespace Core;

/**
 * Class Response
 *
 * The Response class is responsible for creating a response.
 */
class Response
{
    const int HTTP_OK = 200;
    const int HTTP_CREATED = 201;
    const int HTTP_NO_CONTENT = 204;
    const int HTTP_BAD_REQUEST = 400;
    const int HTTP_UNAUTHORIZED = 401;
    const int HTTP_FORBIDDEN = 403;
    const int HTTP_NOT_FOUND = 404;
    const int HTTP_METHOD_NOT_ALLOWED = 405;


    /**
     * Converts the given data to a JSON string, sets the HTTP response code,
     * and returns the JSON string.
     *
     * @param array $data The data to be converted to JSON.
     * @param int $status The HTTP status code.
     * @return false|string The JSON string.
     */
    public static function toJson(array $data = [], int $status = self::HTTP_OK): false|string
    {
        http_response_code($status);
        header('Content-Type: application/json');

        return json_encode($data);
    }
}
