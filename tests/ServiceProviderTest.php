<?php

namespace Michaelr0\ActionsAndFilters\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Blade;
use Michaelr0\ActionsAndFilters\Providers\ActionsAndFiltersServiceProvider;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ActionsAndFiltersServiceProvider::class];
    }

    /** @test */
    public function serviceProviderWorks()
    {
        $this->assertTrue(Blade::compileString("@action('test')") === "<?php Action::run('test'); ?>");
        $this->assertTrue(Blade::compileString("@filter('test')") === "<?php echo Filter::run('test'); ?>");
    }
}
