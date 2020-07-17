<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Michaelr0\ActionsAndFilters\Facades\Action;
use Michaelr0\ActionsAndFilters\ActionsAndFiltersServiceProvider;

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

        // ** Check Actions list and confirm it exists ** //
        $this->assertTrue(is_array(Action::list('Test')));
        // //** Check Actions list and confirm it exists ** //

        // ** Remove Actions from list and test if it worked ** //
        Action::removeAllFor('Test');

        $this->assertNull(Action::list('Test'));
        // //** Remove Actions from list and test if it worked ** //
    }
}
