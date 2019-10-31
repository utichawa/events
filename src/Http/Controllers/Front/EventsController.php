<?php

namespace Utichawa\Events\Http\Controllers\Front;

use Utichawa\Events\Models\Event;
use Illuminate\Http\Request;
use Utichawa\Events\Models\EventCategory;
use App\Http\Controllers\Front\CmsFrontController;

class EventsController extends CmsFrontController
{
    /**
     * @param Request $request
     * @param $menu_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $menu)
    {
        $events = Event::frontFilter($request, $menu->id);

        $event_categories = EventCategory::whereIsActive(true)
            ->whereMenuId($menu->id)
            ->withTranslation()
            ->whereHas('events', function ($query) use ($menu) {
                $query->whereMenuId($menu->id)
                    ->whereIsActive(true);
            })
            ->orderBy('order')
            ->get();

        return view(front_dir() . '.events.index', compact('events', 'event_categories', 'menu'));
    }

    /**
     * @param  int $slug
     * @return  Response
     */
    public function show($slug)
    {
        $event = Event::whereIsActive(true)
            ->with(['translations', 'menu'])
            ->whereHas('translations', function($query) use ($slug) {
                $query->whereSlug($slug)->whereLocale(locale());
            })
            ->firstOrFail();

        $menu = $event->menu;

        return view(front_dir() . '.events.show', compact('event', 'menu'));
    }

    /**
     * Show Event Category and list all active items under this category
     * @param string $menu_slug
     * @param string $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(string $menu_slug, string $category)
    {
        $menu = $this->getMenuFromSlug($menu_slug);

        $events = Event::whereHas('category.translations', function ($query) use ($category) {
            $query->whereSlug($category);
        })
            ->where([
                'is_active' => 1,
                'menu_id' => $menu->id,
            ])
            ->withTranslation()
            ->with(['menu'])
            ->paginate(config('cms.front_pagination.events')); // Todo make this variable events per page

        $event_categories = EventCategory::whereIsActive(true)
            ->whereMenuId($menu->id)
            ->withTranslation()
            ->whereHas('events', function ($query) use ($menu) {
                $query->whereMenuId($menu->id)
                    ->whereIsActive(true);
            })
            ->orderBy('order')
            ->get();

        return view(front_dir() . '.events.index', compact('events', 'menu', 'event_categories'));
    }
}
