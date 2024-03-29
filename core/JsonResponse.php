<?php

namespace Core;

class JsonResponse
{


    /**
     * @param array $data
     * @param int $status
     * @return false|string
     */
    public static function toJson(array $data = [], int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');

        return json_encode($data);
    }
}
