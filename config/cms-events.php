<?php

return [
    'pagination' => 10,
    'route_namespace_controllers' => 'Utichawa\Events\Http\Controllers',
    'module' => [
        'name' => 'Event',
        'reference' => 'events',
        'main_model' => 'Utichawa\Events\Models\Event',
        'widget_orderable_columns' => json_encode(['created_at', 'updated_at', 'start_date', 'end_date']),
        'is_active' => 1,
        'is_menu_module' => true,
        'order' => 50,
        'icon' => 'fa fa-calendar',
        'backend_route' => 'back.events.index',
        'backend_controller' => null,
        'backend_action' => null,
        'except_backend_actions' => null,
        'only_backend_actions' => null,
        'frontend_route' => null,
        'front_namespace' => 'Utichawa\Events\Http\Controllers\Front',
        'front_controller' => 'EventsController',
        'frontend_action' => null,
        'is_on_backend_sidebar' => 0,
        'parent_reference' => null,
    ]
];