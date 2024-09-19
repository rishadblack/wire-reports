<?php

namespace Rishadblack\WireReports;

use Illuminate\Support\ServiceProvider;
use Rishadblack\WireReports\Console\Commands\MakeWireReports;
use Rishadblack\WireReports\Console\Commands\DeleteWireReports;

class WireReportsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'rishadblack');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'rishadblack');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wire-reports.php', 'wire-reports');

        // Register the service the package provides.
        $this->app->singleton('wire-reports', function ($app) {
            return new WireReports();
        });

        // Load views from package
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wire-reports');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wire-reports'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/wire-reports.php' => config_path('wire-reports.php'),
        ], 'wire-reports.config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/wire-reports'),
        ], 'views');


        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/rishadblack'),
        ], 'wire-reports.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/rishadblack'),
        ], 'wire-reports.lang');*/

        // Registering package commands.
        $this->commands([
                MakeWireReports::class,
                DeleteWireReports::class
            ]);

        // Publishing stubs
        $this->publishes([
                    __DIR__.'/../stubs/report-component.stub' => base_path('stubs/report-component.stub'),
                    __DIR__.'/../stubs/report-component-view.stub' => base_path('stubs/report-component-view.stub'),
                ], 'wire-reports-stubs');


    }
}
