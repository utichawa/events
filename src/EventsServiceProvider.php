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
                __DIR__ . '/../resources/views/back' => resource_path('views/back'),
                __DIR__ . '/../resources/views/front' => resource_path('views/front'),
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

            //Publishing Fake data
            $this->publishes([
                __DIR__ . '/../database/factories' => database_path('factories/cms'),
                __DIR__ . '/../database/seeds' => database_path('seeds/cms'),
            ], 'fake_data');
            
            //Publishing Requests
            $this->publishes([
                __DIR__.'/Http/Requests/EventCategoryRequest.php' => app_path('/Http/Requests/EventCategoryRequest.php'),
                __DIR__.'/Http/Requests/EventRequest.php' => app_path('/Http/Requests/EventRequest.php'),
            ], 'requests');
            
            //Publishing Controllers
            $this->publishes([
                __DIR__.'/Http/Controllers/Back' => app_path('/Http/Controllers/Back'),
                __DIR__.'/Http/Controllers/Front' => app_path('/Http/Controllers/Front'),
            ], 'controllers');

            //Publishing Models
            $this->publishes([
                __DIR__.'/Models/Event.php' => app_path('/Models/Cms/Event.php'),
                __DIR__.'/Models/EventTranslation.php' => app_path('/Models/Cms/EventTranslation.php'),
                __DIR__.'/Models/EventCategory.php' => app_path('/Models/Cms/EventCategory.php'),
                __DIR__.'/Models/EventCategoryTranslation.php' => app_path('/Models/Cms/EventCategoryTranslation.php'),
            ], 'models');
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
