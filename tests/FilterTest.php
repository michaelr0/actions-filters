<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Filter;
use Michaelr0\ActionsAndFilters\Filter as FilterClass;
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
        $action = Filter::add('test', function () {
        }, 10, 0);
        $this->assertTrue($action instanceof FilterClass);

        Filter::add('test', 'strtolower', 10, 2);

        $this->assertTrue(Filter::exists('test'));
        $this->assertFalse(Filter::exists('test2'));

        $this->assertTrue(Filter::existsForCallback('test', 'strtolower'));
        $this->assertFalse(Filter::existsForCallback('test', 'strtoupper'));
        $this->assertFalse(Filter::existsForCallback('test2', 'strtoupper'));

        $this->assertNotEmpty(Filter::list('test'));
        $this->assertEmpty(Filter::list('test2'));
        $this->assertEmpty(Filter::list('test', 9));
        $this->assertNotEmpty(Filter::list('test', 10));
        $this->assertEmpty(Filter::list('test2', 10));

        $this->assertNotEmpty(Filter::listAll());

        Filter::remove('test', 'strtolower', 10, 3);
        Filter::remove('test', 'strtoupper', 10, 2);
        Filter::remove('test', 'strtolower', 9, 2);
        $this->assertTrue(Filter::remove('test', 'strtolower', 10, 2) instanceof FilterClass);
        Filter::remove('test', 'strtolower', 10, 2);

        $this->assertTrue(Filter::removeAllFor('test') instanceof FilterClass);

        $this->assertEmpty(Filter::list('test'));

        Filter::removeAllFor('test');

        Filter::add('test', function () {
            return 'foobar';
        }, 10, 0);
        Filter::add('test', 'strtoupper', 10, 1);
        Filter::add('test', function (...$args) {
            return "{$args[0]} {$args[0]}";
        }, 10, 3);

        $this->assertTrue(Filter::run('test', null, null, null) === 'FOOBAR FOOBAR');
    }
}
