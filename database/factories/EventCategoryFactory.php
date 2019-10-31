<?php

use Utichawa\Events\Models\EventCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(EventCategory::class, function (Faker $faker) {

    $event_category = [
        'order' => rand(1, 100),
        'is_active' => rand(0, 1),
        'menu_id' => null,
    ];

    foreach (config('translatable.locales') as $locale) {
        $name = $faker->words(rand(2, 5), true);
        $event_category['slug:' . $locale] =  Str::slug($locale . ' ' . $name);
        $event_category['name:' . $locale] = $locale . ' ' . $name;
        $event_category['description:' . $locale] = 'description' . $locale . ' ' . $faker->sentence;
    }

    return $event_category;
});
