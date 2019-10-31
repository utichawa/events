# Module Events for Cms MEDIANET

[![Latest Version on Packagist](https://img.shields.io/packagist/v/utichawa/events.svg?style=flat-square)](https://packagist.org/packages/utichawa/events)
[![Total Downloads](https://img.shields.io/packagist/dt/utichawa/events.svg?style=flat-square)](https://packagist.org/packages/utichawa/events)

Module events that can be added to any project that has CMS MEDIANET LARAVEL

## Installation

You can install the package via composer:

```bash
composer require utichawa/events
```

### After Installing
You Should go to 'ModulesTableSeeder' file and add this code in the variable $data

``` bash
[
    'name' => config('cms-events.module.name'),
    'reference' => config('cms-events.module.reference'),
    'main_model' => config('cms-events.module.main_model'),
    'widget_orderable_columns' => config('cms-events.module.widget_orderable_columns'),
    'is_active' => config('cms-events.module.is_active'),
    'is_menu_module' => config('cms-events.module.is_menu_module'),
    'order' => config('cms-events.module.order'),
    'icon' => config('cms-events.module.icon'),
    'backend_route' => config('cms-events.module.backend_route'),
    'backend_controller' => config('cms-events.module.backend_controller'),
    'backend_action' => config('cms-events.module.backend_action'),
    'except_backend_actions' => config('cms-events.module.except_backend_actions'),
    'only_backend_actions' => config('cms-events.module.only_backend_actions'),
    'frontend_route' => config('cms-events.module.frontend_route'),
    'front_namespace' => config('cms-events.module.front_namespace'),
    'front_controller' => config('cms-events.module.front_controller'),
    'frontend_action' => config('cms-events.module.frontend_action'),
    'is_on_backend_sidebar' => config('cms-events.module.is_on_backend_sidebar'),
    'parent_reference' => config('cms-events.module.parent_reference'),
],
```

## Usage

``` php
// Usage description here
```

## Credits

- [Mechiche Yassine](https://github.com/utichawa)
- [Lamia Zouaghi](https://github.com/lamiazouaghi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).