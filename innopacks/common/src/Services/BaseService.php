<?php


namespace InnoShop\Common\Services;

class BaseService
{
    protected static $instance;

    /**
     * Get instance
     */
    public static function getInstance(): static
    {
        return new static;
    }

    /**
     * Get singleton instance
     */
    public static function getSingleton(): static
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static;
    }
}
