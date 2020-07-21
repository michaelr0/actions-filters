<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Filter;
use Michaelr0\ActionsAndFilters\Providers\ActionsAndFiltersServiceProvider;

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

        $this->assertEmpty(Filter::list('Test'));
        // //** Remove Filters from list and test if it worked ** //

        Filter::add('Test', 'strtoupper');
        $this->assertTrue(Filter::exists('Test'));
        $this->assertTrue(Filter::existsForCallback('Test', 'strtoupper'));

        $this->assertNotEmpty(Filter::list());
        $this->assertNotEmpty(Filter::list('Test'));
        $this->assertNotEmpty(Filter::list('Test', 10));
        $this->assertNotEmpty(Filter::listAll());

        $this->assertFalse(Filter::exists('Should return false'));
        $this->assertFalse(Filter::existsForCallback('Test', 'strtolower'));
        $this->assertFalse(Filter::existsForCallback('Should return false', 'strtolower'));

        $this->assertEmpty(Filter::list('Should return empty'));
        $this->assertEmpty(Filter::list('Should return empty', 10));

        $this->assertEmpty(Filter::list('Test', 9));

        Filter::removeAllFor('Test');

        $this->assertEmpty(Filter::list('Test'));
    }
}
