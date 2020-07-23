<?php

namespace Michaelr0\ActionsAndFilters\PseudoFacades;

class Action
{
    protected static $class;

    protected static function class()
    {
        if (empty(static::$class)) {
            static::$class = new \Michaelr0\ActionsAndFilters\Action;
        }

        return static::$class;
    }

    public static function __callStatic($method, $args)
    {
        return static::class()->$method(...$args);
    }
}
