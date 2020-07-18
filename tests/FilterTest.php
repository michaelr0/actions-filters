<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Filter;
use Michaelr0\ActionsAndFilters\ActionsAndFiltersServiceProvider;

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

        Filter::add('Test', 'strtoupper');
        $this->assertTrue(Filter::existsFor('Test'));
        $this->assertTrue(Filter::existsForCallback('Test', 'strtoupper'));
        $this->assertTrue(Filter::existsForPriority('Test', 10));

        $this->assertTrue(is_array(Filter::list()));
        $this->assertTrue(is_array(Filter::list('Test')));
        $this->assertTrue(is_array(Filter::list('Test', 10)));
        $this->assertTrue(is_array(Filter::listAll()));

        $this->assertFalse(Filter::existsFor('Should return false'));
        $this->assertFalse(Filter::existsForCallback('Test', 'strtolower'));
        $this->assertFalse(Filter::existsForCallback('Should return false', 'strtolower'));
        $this->assertFalse(Filter::existsForPriority('Should return false', 10));

        $this->assertFalse(is_array(Filter::list('Should return false')));
        $this->assertFalse(is_array(Filter::list('Should return false', 10)));

        $this->assertFalse(is_array(Filter::list('Test', 9)));

        Filter::removeAllFor('Test');

        $this->assertNull(Filter::list('Test'));
    }
}
