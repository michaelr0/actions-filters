<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Action;
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
        // ** Add Action and test if it worked ** //
        $actionsWork = false;
        Action::add('Test', function () use (&$actionsWork) {
            $actionsWork = true;
        });

        Action::run('Test');

        $this->assertTrue($actionsWork);
        // //** Add Action and test if it worked ** //

        // ** Add Action and test if it worked ** //
        Action::add('Test', function () use (&$actionsWork) {
            $actionsWork = false;
        });

        Action::run('Test');

        $this->assertFalse($actionsWork);
        // //** Add Action and test if it worked ** //

        Action::add('Test', 'strtoupper');

        $this->assertTrue(Action::exists('Test'));
        $this->assertTrue(Action::existsForCallback('Test', 'strtoupper'));

        $this->assertNotEmpty(Action::list());
        $this->assertNotEmpty(Action::list('Test'));
        $this->assertNotEmpty(Action::list('Test', 10));
        $this->assertNotEmpty(Action::listAll());

        $this->assertFalse(Action::exists('Should return false'));
        $this->assertFalse(Action::existsForCallback('Test', 'strtolower'));
        $this->assertFalse(Action::existsForCallback('Should return false', 'strtolower'));

        $this->assertEmpty(Action::list('Should return empty'));
        $this->assertEmpty(Action::list('Should return empty', 10));

        $this->assertEmpty(Action::list('Test', 9));

        Action::removeAllFor('Test');

        $this->assertEmpty(Action::list('Test'));
    }
}
