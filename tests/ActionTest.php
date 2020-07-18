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

        Action::add('Test', 'strtoupper');

        $this->assertTrue(Action::existsFor('Test'));
        $this->assertTrue(Action::existsForCallback('Test', 'strtoupper'));
        $this->assertTrue(Action::existsForPriority('Test', 10));

        $this->assertTrue(is_array(Action::list()));
        $this->assertTrue(is_array(Action::list('Test')));
        $this->assertTrue(is_array(Action::list('Test', 10)));
        $this->assertTrue(is_array(Action::listAll()));

        $this->assertFalse(Action::existsFor('Should return false'));
        $this->assertFalse(Action::existsForCallback('Test', 'strtolower'));
        $this->assertFalse(Action::existsForCallback('Should return false', 'strtolower'));
        $this->assertFalse(Action::existsForPriority('Should return false', 10));

        $this->assertFalse(is_array(Action::list('Should return false')));
        $this->assertFalse(is_array(Action::list('Should return false', 10)));

        $this->assertFalse(is_array(Action::list('Test', 9)));

        Action::removeAllFor('Test');

        $this->assertNull(Action::list('Test'));
    }
}
