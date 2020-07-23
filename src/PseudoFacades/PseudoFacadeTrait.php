<?php

namespace Michaelr0\ActionsAndFilters\PseudoFacades;

trait PseudoFacadeTrait
{
    protected static $class;

    // protected static $instance = '\Michaelr0\ActionsAndFilters\Action';
    // protected static $instance = '\Michaelr0\ActionsAndFilters\Filter';

    protected static function class()
    {
        if (empty(static::$class) && ! empty(static::$instance)) {
            static::$class = new static::$instance;
        }

        return static::$class;
    }

    public static function __callStatic($method, $args)
    {
        return static::class()->$method(...$args);
    }
}
