<?php

use Illuminate\Database\Seeder;

use App\Models\Cms\Menu;
use Utichawa\Events\Models\Event;
use App\Models\Cms\Module;
use App\Models\Cms\MenuGroup;
use Illuminate\Support\Str;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main menu
        $mainMenuId = MenuGroup::whereReference('main-menu')->first()->id;
        $this->event($mainMenuId, 'Event');
    }

    public function event(int $menuGroupId, string $label)
    {
        $moduleId = Module::whereReference(config('cms-events.module.reference'))->first()->id;

        $menu = $this->menuFactory($menuGroupId, $moduleId, $label);

        factory('Utichawa\Events\Models\EventCategory', rand(5, 8))->create([
            'menu_id' => $menu->id,
        ])->each(function ($model_category) use ($menu) {
            $model_category->events()->saveMany(factory('Utichawa\Events\Models\Event', rand(5, 10))->make([
                'menu_id' => $menu->id,
            ]));
        });
    }

    public function menuFactory(int $menuGroupId, int $moduleId, string $label): Menu
    {
        $menu = [
            'menu_group_id' => $menuGroupId,
            'module_id' => $moduleId,
            'http_protocol' => null,
            'external_link' => null,
            'internal_link' => null,
            'link_target' => null,
            'is_active' => 1,
            'icon' => '',
            'order' => 10,
            'css_class' => '',
            'image1' => '',
        ];

        foreach (config('translatable.locales') as $locale) {
            $menu[$locale] = [
                'locale' => $locale,
                'label' => $locale . ' ' . $label,
                'slug' => Str::slug($locale . ' ' . $label),
                'meta_title' => $locale . ' ' . $label,
                'meta_description' => $locale . ' ' . $label,
                'content' => $locale . ' ' . $label,
            ];
        }

        return Menu::create($menu);
    }

}
