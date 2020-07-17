<?php

namespace Michaelr0\ActionsAndFilters\Facades;

use Illuminate\Support\Facades\Facade;

class Action extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'action';
    }
}