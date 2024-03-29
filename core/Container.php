<?php

namespace Core;

use Exception;

/**
 * Class Container
 *
 * The Container class is a simple dependency injection container.
 * It allows registering dependencies and retrieving them by name.
 */
class Container
{
    /**
     * @var array The registered dependencies.
     */
    private array $dependencies = [];

    /**
     * Register a new dependency.
     *
     * @param string $name The name of the dependency.
     * @param callable $resolver The resolver function for the dependency.
     */
    public function register(string $name, callable $resolver): void
    {
        $this->dependencies[$name] = $resolver;
    }


    /**
     * Get an instance of the dependency.
     *
     * @param string $name The name of the dependency.
     * @return mixed The instance of the dependency.
     * @throws Exception If the dependency is not found.
     */
    public function get(string $name): mixed
    {
        if (isset($this->dependencies[$name])) {
            $resolver = $this->dependencies[$name];
            return $resolver($this);
        }

        throw new Exception("Dependency '$name' not found.");
    }
}