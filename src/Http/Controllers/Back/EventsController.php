<?php

namespace Utichawa\Events\Http\Controllers\Back;

use Utichawa\Events\Models\Event;
use Illuminate\Http\Request;
use Utichawa\Events\Models\EventCategory;
use Utichawa\Events\Http\Requests\EventRequest;
use Utichawa\Events\Http\Controllers\Controller;

class EventsController extends Controller
{
    protected $mainModel = 'Utichawa\Events\Models\Event';

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->toggleStatus) {
            return $this->toggleStatus($request);
        }
        
        $menu_id = $this->getMenuIdOrFail($request);

        if ($request->ajax() OR $request->debug) {
            return $this->datatables($request);
        }

        return view('back.events.index', compact('menu_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu_id = $this->getMenuIdOrFail($request);

        $event_categories = EventCategory::getSelectOptionsForMenu($menu_id);

        return view('back.events.create', compact('event_categories', 'menu_id'));
    }

    /**
     * @param   \Utichawa\Events\Http\Requests\EventRequest $request
     * @return  \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = Event::create($request->prepared());

        if ($request->hasFile('image')) {
            $event->addMediaFromRequest('image')->toMediaCollection();
        }

        if ($request->hasFile('gallery')) {
            $event->addMultipleMediaFromRequest(['gallery'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('event_medias');
                });
        }

        return redirect()->route('back.events.show', $event->id)
            ->with('success', trans('og.alert.success'));
    }

    /**
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::withTranslation()
            ->with([
                'menu' => function ($query) {
                    $query->withTranslation();
                },
            ])->findOrFail($id);

        return view('back.events.show', compact('event'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::with('category', 'media')->findOrFail($id);

        $event_categories = EventCategory::where(['menu_id' => $event->menu_id, 'is_active' => 1])->get();

        return view('back.events.edit', compact('event', 'event_categories'));
    }

    /**
     * @param   \Utichawa\Events\Http\Requests\EventRequest $request
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $data = $request->prepared();

        $event = Event::with('media')->find($id);
        $event->update($data);

        if ($request->hasFile('image')) {
            if ($media = $event->media->first()) {
                $media->delete();
            }
            $event->addMediaFromRequest('image')->toMediaCollection();
        }

        if ($request->hasFile('gallery')) {
            $event->clearMediaCollectionExcept('event_medias', $event->getFirstMedia());
            $event->addMultipleMediaFromRequest(['gallery'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('event_medias');
                });
        }

        return redirect()->route('back.events.show', $event->id)->with('success',
            trans('og.alert.success'));
    }

    /**
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $menu_id = $event->menu_id;

        $event->delete();

        return redirect()->route('back.events.index', ['menu_id' => $menu_id])->with('success',
            trans('og.alert.success'));
    }


    public function datatables(Request $request)
    {
        $where = $request->menu_id ? [(new Event())->getTable() . '.menu_id' => $request->menu_id] : [];

        $events = Event::withTranslation()
            ->with('category.translations')
            ->where($where)
            ->select((new Event)->getTable() . '.*');

        return datatables()->of($events)
            ->editColumn('id',
                '<a href="{{route(\'back.events.show\', ["id" => $id])}}">{{$id}}</a>')
            ->addColumn('category', function ($model) {
                return '<a href="' . route('back.event_categories.show',
                    $model->event_category_id) . '">' . $model->category->name . '</a>' ?? null;
            })
            ->addColumn('name', function ($model) {
                return $model->translations->first()->name ?? null;
            })
            ->addColumn('start_date', function ($model) {
                return $model->first()->start_date ? date('d-m-Y', strtotime($model->start_date)) : null;
            })
            ->addColumn('end_date', function ($model) {
                return $model->first()->end_date ? date('d-m-Y', strtotime($model->end_date)) : null;
            })
            ->addColumn('description', function ($model) {
                return $model->translations->first()->description ?? null;
            })
            ->addColumn('content', function ($model) {
                return $model->translations->first()->content ?? null;
            })
            ->addColumn('actions', function ($model) {
                return $model->enable_button . ' ' . $model->show_button . ' ' . $model->edit_button . ' ' . $model->delete_button;
            })
            ->rawColumns(['id', 'is_active', 'category', 'actions'])
            ->make(true);
    }
}
