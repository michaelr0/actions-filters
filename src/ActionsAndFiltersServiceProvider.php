<?php

namespace Michaelr0\ActionsAndFilters;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Michaelr0\ActionsAndFilters\Action;
use Michaelr0\ActionsAndFilters\Filter;

class ActionsAndFiltersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Blade::directive('action', function ($expression) {
            return "<?php Action::run({$expression}); ?>";
        });

        Blade::directive('filter', function ($expression) {
            return "<?php echo Filter::run({$expression}); ?>";
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('action', function () {
            return new Action;
        });

        $this->app->singleton('filter', function () {
            return new Filter;
        });
    }
}
