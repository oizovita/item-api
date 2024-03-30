<?php

namespace Core;

use Exception;

/**
 * Class Router
 *
 * The Router class is responsible for mapping incoming HTTP requests to the appropriate route.
 * It provides a method to map the request and return the corresponding controller, action, and parameters.
 */
class Router
{
    /**
     * @var mixed The routes defined in the application.
     */
    private mixed $routes;

    /**
     * Router constructor.
     *
     * @param string $file The file containing the route definitions.
     */
    public function __construct(string $file)
    {
        $this->routes = json_decode($file, true);
    }

    /**
     * Maps the incoming request to the appropriate route.
     *
     * @return array The controller, action, and parameters for the route.
     * @throws Exception If the route is not found or the method is not allowed.
     */
    public function mapRequest(): array
    {
        $result = [];
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);

        $path = $parsed_url['path'] ?? '/';

        $routeNotFound = true;
        $methodNotAllowed = true;
        foreach ($this->routes as $route) {
            if (preg_match("#^$route[path]$#", $path, $matches)) {
                $routeNotFound = false;
                if ($route['method'] === $_SERVER['REQUEST_METHOD']) {
                    $methodNotAllowed = false;
                    array_shift($matches);
                    $result['controller'] = $route['controller'];
                    $result['action'] = $route['action'];
                    $result['middlewares'] = $route['middlewares'] ?? [];
                    if (!empty($matches)) {
                        $result['params'] = array_shift($matches);
                    }
                    break;
                }
            }
        }

        if ($routeNotFound) {
            throw new Exception('Not Found', Response::HTTP_NOT_FOUND);
        }

        if ($methodNotAllowed) {
            throw new Exception('Method Not Allowed', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return $result;
    }
}