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
        if ($this->app->runningInConsole()) {

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/events'),
            ], 'views');

            // Publishing the config.
            $this->publishes([
                __DIR__ . '/../config/cms-events.php' => config_path('cms-events.php'),
            ], 'config');

            // Publishing migrations 
            $this->publishes([
                __DIR__ . '/../database/migrations/create_event_categories_table.stub.php' => database_path('migrations/cms/' . date('Y_m_d_His', time()) . '_create_event_categories_table.php'),
                __DIR__ . '/../database/migrations/create_events_table.stub.php' => database_path('migrations/cms/' . date('Y_m_d_His', time()) . '_create_events_table.php'),
            ], 'migrations');
            
            
        }
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
