<?php

namespace Michaelr0\ActionsAndFilters\Providers;

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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('actionsandfilters.php'),
            ], 'config');
        }

        if (function_exists('config') && config('actions-filters.blade.enable_action_directive')) {
            Blade::directive('action', function ($expression) {
                return "<?php Action::run({$expression}); ?>";
            });
        }

        if (function_exists('config') && config('actions-filters.blade.enable_filter_directive')) {
            Blade::directive('filter', function ($expression) {
                return "<?php echo Filter::run({$expression}); ?>";
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'actions-filters');

        // Register the Action class to use with the Action facade
        $this->app->singleton('action', function () {
            return new Action;
        });

        // Register the Filter class to use with the Filter facade
        $this->app->singleton('filter', function () {
            return new Filter;
        });
    }
}
