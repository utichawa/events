<?php

use Illuminate\Database\Seeder;
use App\Models\Cms\Module;

class ModuleEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *
         * IMPORTANT ! ****************!
         * Do not change the modules ids
         *
         */
        $data = [
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
        ];

        Cache::forget('active_locales'); // Update active locales [bugfix: during the installation of demo]
        config(['translatable.locales' => get_translatable_locales()]);
        $locales = get_translatable_locales();

        foreach ($data as $d) {

            $parent_id = self::getParentIdForModule($d);

            if (Module::where('reference', $d['reference'])->get()->isEmpty()) {
                $module = [
                    'reference' => $d['reference'],
                    'main_model' => $d['main_model']??null,
                    'widget_orderable_columns' => $d['widget_orderable_columns']??null,
                    'is_active' => $d['is_active'],
                    'is_menu_module' => $d['is_menu_module'],
                    'order' => $d['order'],
                    'icon' => $d['icon'],
                    'backend_route' => $d['backend_route'],
                    'frontend_route' => $d['frontend_route'],
                    'front_namespace' => $d['front_namespace'],
                    'front_controller' => $d['front_controller'],
                    'is_on_backend_sidebar' => $d['is_on_backend_sidebar'],
                    'parent_id' => $parent_id,
                ];
                foreach ($locales as $locale) {
                    $module[$locale]['name'] = $d['name'];
                }
                Module::create($module);
            }
        }
    }

    public static function getParentIdForModule(array $d)
    {
        if (isset($d['parent_reference']) && $d['parent_reference']) {
            return Module::where('reference', $d['parent_reference'])->first()->id ?? null;
        }

        return null;
    }
}
