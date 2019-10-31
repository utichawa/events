<?php

namespace Utichawa\Events\Http\Controllers\Back;

use Illuminate\Http\Request;
use Utichawa\Events\Models\EventCategory;
use Utichawa\Events\Http\Requests\EventCategoryRequest;
use App\Http\Controllers\Controller;

class EventCategoriesController extends Controller
{
    protected $mainModel = 'Utichawa\Events\Models\EventCategory';

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

        return view('back.event_categories.index', compact('menu_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu_id = $this->getMenuIdOrFail($request);

        return view('back.event_categories.create', compact('menu_id'));
    }

    /**
     * @param   \Utichawa\Events\Http\Requests\EventCategoryRequest $request
     * @return  \Illuminate\Http\Response
     */
    public function store(EventCategoryRequest $request)
    {
        $event_category = EventCategory::create($request->prepared());

        return redirect()->route('back.event_categories.show',
            $event_category->id)->with('success', trans('og.alert.success'));
    }

    /**
     * @param    int $id
     * @return  Response
     */
    public function show($id)
    {
        $event_category = EventCategory::withTranslation()
            ->with([
                'menu' => function ($query) {
                    $query->withTranslation();
                },
            ])->findOrFail($id);

        return view('back.event_categories.show', compact('event_category'));
    }

    /**
     * @param EventCategory $event_category
     * @return \Illuminate\Http\Response
     */
    public function edit(EventCategory $event_category)
    {
        return view('back.event_categories.edit', compact('event_category'));
    }

    /**
     * @param \Utichawa\Events\Http\Requests\EventCategoryRequest $request
     * @param    int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventCategoryRequest $request, $id)
    {
        $event_category = EventCategory::findOrFail($id);

        $event_category->update($request->prepared());

        return redirect()->route('back.event_categories.show',
            $event_category->id)->with('success', trans('og.alert.success'));
    }

    /**
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event_category = EventCategory::findOrFail($id);
        $menu_id = $event_category->menu_id;

        $event_category->delete();

        return redirect()->route('back.event_categories.index', ['menu_id' => $menu_id])->with('success',
            trans('og.alert.success'));
    }

    public function datatables(Request $request)
    {
        $where = $request->menu_id ? [(new EventCategory())->getTable() . '.menu_id' => $request->menu_id] : [];

        $event_categories = EventCategory::withTranslation()
            ->where($where)
            ->select((new EventCategory())->getTable() . '.*');

        return datatables()->of($event_categories)
            ->editColumn('id',
                '<a href="{{route(\'back.event_categories.show\', ["id" => $id])}}">{{$id}}</a>')
            ->addColumn('slug', function ($model) {
                return $model->translations->first()->slug ?? null;
            })
            ->addColumn('name', function ($model) {
                return $model->translations->first()->name ?? null;
            })
            ->addColumn('description', function ($model) {
                return $model->translations->first()->description ?? null;
            })
            ->addColumn('actions', function ($model) {
                return $model->enable_button . ' ' . $model->show_button . ' ' . $model->edit_button . ' ' . $model->delete_button;
            })->rawColumns(['id', 'is_active', 'actions'])
            ->make(true);
    }
}
