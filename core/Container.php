<?php

namespace Core;

use Exception;

class Container
{
    private $dependencies = [];

    /**
     * Register a new dependency
     * @param $name
     * @param $resolver
     */
    public function register($name, $resolver): void
    {
        $this->dependencies[$name] = $resolver;
    }


    /**
     * Get an instance of the dependency
     * @throws Exception
     */
    public function get($name)
    {
        if (isset($this->dependencies[$name])) {
            $resolver = $this->dependencies[$name];
            return $resolver($this);
        }

        throw new Exception("Dependency '$name' not found.");
    }
}