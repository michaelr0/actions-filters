<?php

namespace Michaelr0\ActionsAndFilters;

use Michaelr0\ActionsAndFilters\Traits\Hookable;

class Filter
{
    use Hookable;

    public function run(string $hook, ...$args)
    {
        return $this->runRecursiveAndReturn($hook, $args);
    }

    public function runRecursive(string $hook, ...$args)
    {
        return $this->runRecursiveAndReturn($hook, $args);
    }
}
