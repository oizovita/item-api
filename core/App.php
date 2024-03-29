<?php

namespace Core;

use Exception;
use ReflectionClass;
use Src\Contracts\ItemRepositoryInterface;
use Src\Contracts\UserRepositoryInterface;
use Src\Middleware\BasicAuthMiddleware;
use Src\Repositories\ItemRepository;
use Src\Repositories\UserRepository;

final class App
{
    private static ?App $instance = null;
    private Container $container;

    private function __construct()
    {
        $this->container = new Container();
        $this->registerDependencies();
    }

    private function registerDependencies(): void
    {
        $this->container->register(ItemRepositoryInterface::class, function () {
            return new ItemRepository();
        });
        $this->container->register(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });
    }

    public static function getInstance(): App
    {
        if (static::$instance === null) {
            static::$instance = new App();
        }

        return static::$instance;
    }

    public function handle(Router $router): string
    {
        try {

            $result = $router->mapRequest();
            $controller = $this->createController($result['controller']);
            $action = $result['action'];
            $request = new Request($result['params'] ?? []);

            if (in_array('auth', $result['middlewares'])) {
                $middleware = new BasicAuthMiddleware($this->container->get(UserRepositoryInterface::class));
                $middleware->handle($request, function () use ($controller, $action, $result, $request) {
                    return $this->callAction($controller, $action, $request);
                });
            }


            return $this->callAction($controller, $action, $request);

        } catch (Exception $exception) {
            return JsonResponse::toJson(['Error' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function createController(string $controllerName): object
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

    private function callAction($controller, $action, Request $request)
    {
        return $controller->$action($request);
    }
}