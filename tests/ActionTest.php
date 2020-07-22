<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Action;
use Michaelr0\ActionsAndFilters\Action as ActionClass;
use Michaelr0\ActionsAndFilters\Providers\ActionsAndFiltersServiceProvider;

class ActionTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ActionsAndFiltersServiceProvider::class];
    }

    /** @test */
    public function actionsWork()
    {
        $action = Action::add('test', function () {
        }, 10, 0);
        $this->assertTrue($action instanceof ActionClass);

        Action::add('test', 'array_merge', 10, 2);

        $this->assertTrue(Action::exists('test'));
        $this->assertFalse(Action::exists('test2'));

        $this->assertTrue(Action::existsForCallback('test', 'array_merge'));
        $this->assertFalse(Action::existsForCallback('test', 'strtoupper'));
        $this->assertFalse(Action::existsForCallback('test2', 'strtoupper'));

        $this->assertNotEmpty(Action::list('test'));
        $this->assertEmpty(Action::list('test2'));
        $this->assertEmpty(Action::list('test', 9));
        $this->assertNotEmpty(Action::list('test', 10));
        $this->assertEmpty(Action::list('test2', 10));

        $this->assertNotEmpty(Action::listAll());

        Action::remove('test', 'array_merge', 10, 3);
        Action::remove('test', 'strtoupper', 10, 2);
        Action::remove('test', 'array_merge', 9, 2);
        $this->assertTrue(Action::remove('test', 'array_merge', 10, 2) instanceof ActionClass);
        Action::remove('test', 'array_merge', 10, 2);

        $this->assertTrue(Action::removeAllFor('test') instanceof ActionClass);

        $this->assertEmpty(Action::list('test'));

        $actionsWork = false;
        Action::add('test', function () use (&$actionsWork) {
            $actionsWork = true;
        });
        Action::run('test');
        $this->assertTrue($actionsWork);
        Action::add('test', function () use (&$actionsWork) {
            $actionsWork = false;
        });
        Action::run('test');
        $this->assertFalse($actionsWork);

        Action::removeAllFor('test');

        Action::add('test', 'array_merge', 10, 2);
        $this->assertTrue(Action::run('test', [], []) instanceof ActionClass);

        Action::run('test', [], [], []);

        Action::removeAllFor('test');
        Action::add('test', function () {
        }, 10, 0);
        Action::run('test');
    }
}
