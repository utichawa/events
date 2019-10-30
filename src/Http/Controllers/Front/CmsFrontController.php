<?php

namespace Utichawa\Events\Http\Controllers\Front;

use Utichawa\Events\Models\Menu;
use Illuminate\Http\Request;
use Utichawa\Events\Services\Cms\CmsLocale;
use Utichawa\Events\Models\MenuTranslation;
use Utichawa\Events\Http\Controllers\Controller;

class CmsFrontController extends Controller
{
    /**
     * @param $menu_slug string
     * @return \Utichawa\Events\Models\Menu
     */
    public function getMenuFromSlug(string $menu_slug): Menu
    {
        return Menu::with(['module', 'translations'])
            ->whereHas('translations', function ($query) use ($menu_slug) {
                $query->whereIsActive(true)
                    ->whereSlug($menu_slug)
                    ->whereLocale(locale());
            })->firstOrFail();
    }

    /**
     * @param Request $request
     * @return Menu
     */
    public function getMenuFromUrl(Request $request): Menu
    {
        $slug = $this->getSlugFromUrl($request);

        $menuTranslation = MenuTranslation::where('slug', $slug)
            ->with([
                'menu' => function ($query) {
                    $query->withTranslation();
                },
            ])
            ->firstOrfail();

        return $menuTranslation->menu;
    }

    /**
     * @return string
     */
    public function getSlugFromUrl(): string
    {
        return CmsLocale::getNonLocaleFirstSegment();
    }

    /**
     * @return int
     */
    public function getMenuIdFromUrl(): int
    {
        $slug = $this->getSlugFromUrl();

        $menu_translation = MenuTranslation::select('menu_id')->whereSlug($slug)->firstOrFail();

        return $menu_translation->menu_id;
    }

    public function ogTags()
    {
        return [
            'url' => url()->current(),
            'title' => get_cached_parameters('website_name'),
            'type' => 'article',
            'description' => get_cached_parameters('description'),
            'image' => get_cached_parameters('main_logo'),
            'site_name' => get_cached_parameters('website_name'),
            'updated_time' => time(),
            'image:alt' => get_cached_parameters('website_name'),
        ];
    }

//
//    public function abortWrongPagination($collection)
//    {
//        if(!$collection->count() && request('page')){
//            abort(404);
//        }
//    }
}
