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

#### Add Module :

``` bash
php artisan db:seed --class=ModuleEventTableSeeder
```

#### Add Routes
Add this line to the config file 'packages.php'
```php
'events' => config('cms-events.route_namespace_controllers')
```

## Adding fake events
You should add this line to the file DatabaseSeeder under the fucntion fakeData

But before that execute this command
``` bash
composer dump
```
``` php
public function fakeData()
    {
        if (config('app.env') == 'local') {
            //.....
            $this->call(EventsTableSeeder::class);
            //.....
        }
    }
```

## Credits

- [Mechiche Yassine](https://github.com/utichawa)
- [Lamia Zouaghi](https://github.com/lamiazouaghi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).