<?php

namespace Core;


class Request
{
    private array $params;
    private string $reqMethod;
    private string $contentType;

    private string $auth_user;
    private string $auth_pw;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->reqMethod = trim($_SERVER['REQUEST_METHOD']);
        $this->contentType = !empty($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        $this->auth_user = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->auth_pw = $_SERVER['PHP_AUTH_PW'] ?? null;
    }

    /**
     * @return array
     */
    public function getParam(): array
    {
        return $this->params[0];
    }

    /**
     * @return array
     */
    public function getJSON(): array
    {
        if ($this->reqMethod !== 'POST') {
            return [];
        }

        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            return [];
        }

        // Receive the RAW post data.
        $content = trim(file_get_contents("php://input"));
        return json_decode($content, true);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->reqMethod;
    }

    /**
     * @return string
     */
    public function getAuthUser(): string
    {
        return $this->auth_user;
    }

    /**
     * @return string
     */
    public function getAuthPw(): string
    {
        return $this->auth_pw;
    }
}
