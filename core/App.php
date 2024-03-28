<?php

namespace Core;

use Exception;
use Src\Contracts\ItemRepositoryInterface;
use Src\Repositories\ItemRepository;

/**
 * Class App
 */
final class App
{
    private static $instance;
    private Container $container;

    /**
     * App constructor.
     */
    private function __construct()
    {
        $this->container = new Container();
        $this->registerDependencies();
    }

    private function registerDependencies(): void
    {
        $this->container->set(ItemRepositoryInterface::class, function () {
            return new ItemRepository();
        });
    }

    /**
     * Create singleton object
     *
     * @return mixed
     */
    public static function getInstance(): mixed
    {
        if (static::$instance === null) {
            static::$instance = new App();
        }

        return static::$instance;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Method for star server
     *
     * @param Router $router
     * @return mixed
     */
    public function handle(Router $router)
    {
        try {
            $result = $router->mapRequest();
            $controller = "Src\\Controllers\\$result[controller]";
            $action = $result['action'];
            if (isset($result['params'])) {
                return (new $controller)->$action(new Request($result['params']));
            }

            return (new $controller)->$action();
        } catch (Exception $exception) {
            echo json_encode(['Error' => $exception->getMessage()]);
        }
    }
}