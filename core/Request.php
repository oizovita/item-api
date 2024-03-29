<?php

namespace Core;

/**
 * Class Request
 *
 * The Request class is responsible for handling the incoming HTTP request.
 * It provides methods to retrieve the request parameters, the request method, and the authentication credentials.
 */
class Request
{
    /**
     * @var int|null The request parameters.
     */
    private ?int $params;

    /**
     * @var string The HTTP request method.
     */
    private string $reqMethod;

    /**
     * @var string|null The username for HTTP Basic Authentication.
     */
    private ?string $auth_user;

    /**
     * @var string|null The password for HTTP Basic Authentication.
     */
    private ?string $auth_pw;

    /**
     * Request constructor.
     *
     * @param string|null $params The request parameters.
     */
    public function __construct(?string $params = null)
    {
        $this->params = $params;
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
        $this->auth_user = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->auth_pw = $_SERVER['PHP_AUTH_PW'] ?? null;
    }

    /**
     * Returns the request parameters.
     *
     * @return int|null The request parameters.
     */
    public function getParam(): ?int
    {
        return $this->params;
    }


    /**
     * Returns the request data.
     *
     * @return array The request data.
     */
    public function getData(): array
    {
        $content = file_get_contents("php://input");
        return json_decode($content, true);
    }

    /**
     * Returns the HTTP request method.
     *
     * @return string The HTTP request method.
     */
    public function getMethod(): string
    {
        return $this->reqMethod;
    }

    /**
     * Returns the username for HTTP Basic Authentication.
     *
     * @return string|null The username for HTTP Basic Authentication.
     */
    public function getAuthUser(): ?string
    {
        return $this->auth_user;
    }

    /**
     * Returns the password for HTTP Basic Authentication.
     *
     * @return string|null The password for HTTP Basic Authentication.
     */
    public function getAuthPw(): ?string
    {
        return $this->auth_pw;
    }
}