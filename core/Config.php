<?php

namespace Core;

/**
 * Class Config
 *
 * The Config class is responsible for managing the application's configuration settings.
 * It provides a method to get a configuration value by its key.
 */
class Config
{
    /**
     * @var array|null The configuration settings.
     */
    private static array|null $config = null;

    /**
     * Returns the configuration value for the given key.
     *
     * @param string $key The configuration key.
     * @param mixed|null $default The default value to return if the configuration key does not exist.
     * @return mixed The configuration value.
     */
    public static function get(string $key, mixed $default = null)
    {
        if (is_null(self::$config)) {
            self::$config = require_once(__DIR__ . '/../config.php');
        }

        return !empty(self::$config[$key]) ? self::$config[$key] : $default;
    }
}

