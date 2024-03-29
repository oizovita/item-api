<?php

namespace Core;

class Request
{
    private ?int $params;
    private string $reqMethod;
    private ?string $auth_user;
    private ?string $auth_pw;

    public function __construct(?string $params = null)
    {
        $this->params = $params;
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
        $this->auth_user = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->auth_pw = $_SERVER['PHP_AUTH_PW'] ?? null;
    }

    public function getParam(): ?int
    {
        return $this->params;
    }

    public function getData(): array
    {
        $content = file_get_contents("php://input");
        return json_decode($content, true);
    }

    public function getMethod(): string
    {
        return $this->reqMethod;
    }

    public function getAuthUser(): ?string
    {
        return $this->auth_user;
    }

    public function getAuthPw(): ?string
    {
        return $this->auth_pw;
    }
}