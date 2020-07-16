<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\ActionsAndFiltersServiceProvider;
use Michaelr0\ActionsAndFilters\Facades\Filter;

class FilterTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ActionsAndFiltersServiceProvider::class];
    }

    /** @test */
    public function filtersWork()
    {
        // ** Add Filter and test if it worked ** //
        Filter::add('Test', 'strtolower');
        $this->assertTrue((Filter::run('Test', 'TEST') === 'test'));
        // //** Add Filter and test if it worked ** //

        // ** Add Additional Filter and test if it worked ** //
        Filter::add('Test', 'ucfirst');
        $this->assertTrue((Filter::run('Test', 'TEST') === 'Test'));
        // //** Add Additional Filter and test if it worked ** //

        // ** Check Filters list and confirm it exists ** //
        $this->assertTrue(is_array(Filter::list('Test')));
        // //** Check Filters list and confirm it exists ** //

        // ** Remove Filters from list and test if it worked ** //
        Filter::removeAllFor('Test');

        $this->assertNull(Filter::list('Test'));
        // //** Remove Filters from list and test if it worked ** //

    }
}
