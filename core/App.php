<?php

namespace Core;

use Exception;
use ReflectionClass;
use Src\Contracts\ItemRepositoryInterface;
use Src\Contracts\UserRepositoryInterface;
use Src\Middleware\BasicAuthMiddleware;
use Src\Repositories\ItemRepository;
use Src\Repositories\UserRepository;

/**
 * Class App
 *
 * The main application class that handles the request and response.
 * It also manages the dependency injection container.
 */
final class App
{
    /**
     * @var App|null The singleton instance of the App class.
     */
    private static ?App $instance = null;

    /**
     * @var Container The dependency injection container.
     */
    private Container $container;

    /**
     * App constructor.
     *
     * Private to prevent creating multiple instances.
     */
    private function __construct()
    {
        $this->container = new Container();
        $this->registerDependencies();
    }


    /**
     * Registers the dependencies in the container.
     */
    private function registerDependencies(): void
    {
        $this->container->register(ItemRepositoryInterface::class, function () {
            return new ItemRepository();
        });
        $this->container->register(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });
    }

    /**
     * Returns the singleton instance of the App class.
     *
     * @return App The singleton instance.
     */
    public static function getInstance(): App
    {
        if (static::$instance === null) {
            static::$instance = new App();
        }

        return static::$instance;
    }

    /**
     * Handles the incoming request and returns the response.
     *
     * @param Router $router The router instance.
     * @return string The response.
     */
    public function handle(Router $router): string
    {
        try {
            $result = $router->mapRequest();
            $controller = $this->createController($result['controller']);
            $action = $result['action'];
            $request = new Request($result['params'] ?? null);

            if (in_array('auth', $result['middlewares'])) {
                $middleware = new BasicAuthMiddleware($this->container->get(UserRepositoryInterface::class));
                $response = $middleware->handle($request, function () use ($controller, $action, $result, $request) {
                    return $this->callAction($controller, $action, $request);
                })();
            } else {
                $response = $this->callAction($controller, $action, $request);
            }

        } catch (Exception $exception) {
            $response = new Response(['Error' => $exception->getMessage()], $exception->getCode());
        }

        return $response->toJson();
    }

    /**
     * Creates a controller instance with its dependencies.
     *
     * @param string $controllerName The name of the controller.
     * @return Controller The controller instance.
     * @throws \ReflectionException If the class does not exist.
     */
    private function createController(string $controllerName): Controller
    {
        $controller = "Src\\Controllers\\$controllerName";
        $reflectionClass = new ReflectionClass($controller);
        $constructor = $reflectionClass->getConstructor();
        $parameters = $constructor->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $class = $parameter->getType();
            if ($dependency = $this->container->get($class->getName())) {
                $dependencies[] = $dependency;
            }
        }

        return new $controller(...$dependencies);
    }

    /**
     * Calls the action method on the controller with the request.
     *
     * @param Controller $controller The controller instance.
     * @param string $action The action method name.
     * @param Request $request The request instance.
     * @return Response The result of the action method.
     */
    private function callAction(Controller $controller, string $action, Request $request): Response
    {
        return $controller->$action($request);
    }
}