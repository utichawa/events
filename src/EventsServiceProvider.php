<?php

namespace Utichawa\Events;

use Illuminate\Support\ServiceProvider;

class EventsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'events');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'events');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/events'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/events'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/events'),
        ], 'views');

        // Publishing the config.
        $this->publishes([
            __DIR__ . '/../config/cms-events.php' => config_path('config/cms-events.php'),
        ], 'config');

        // Publishing migrations 
        $this->publishes([
            __DIR__ . '/../database/migrations/create_event_categories_table.stub.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_event_categories_table.php'),
            __DIR__ . '/../database/migrations/create_events_table.stub.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_events_table.php'),
        ], 'migrations');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/cms-events.php', 'events');

    }
}
