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

    private array $data;
    private int $status;

    public function __construct(array $data = [], int $status = self::HTTP_OK)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Converts the given data to a JSON string, sets the HTTP response code,
     * and returns the JSON string.
     *
     * @return false|string The JSON string.
     */
    public function toJson(): false|string
    {
        http_response_code($this->status);
        header('Content-Type: application/json');

        return json_encode($this->data);
    }
}
