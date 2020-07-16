<?php

namespace Michaelr0\LaravelActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\LaravelActionsAndFilters\LaravelActionsAndFiltersServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelActionsAndFiltersServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
