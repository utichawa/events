<?php

namespace Utichawa\Events\Models;

use Carbon\Carbon;
use Utichawa\Translatable\Translatable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use App\Models\Traits\UpdaterTrait;
use App\Models\Cms\Menu;
use App\Models\BaseModel;

class Event extends BaseModel implements HasMedia
{
    use SoftDeletes, Translatable, UpdaterTrait, HasMediaTrait, CascadeSoftDeletes;

    protected $cascadeDeletes = ['translations'];

    public $translatedAttributes = [
        'slug',
        'name',
        'description',
        'image',
        'content',
        'meta_title',
        'meta_description',
    ];
    protected $buttonsRouteNamePrefix = 'back.events';
    protected $dates = [
        'deleted_at',
        'start_date',
        'end_date',
    ];

    protected $fillable = [
        'is_active',
        'start_date',
        'end_date',
        'menu_id',
        'event_category_id',
    ];

    // belongsTo Relationships

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    // scopes
    public function scopeFrontFilter($query, $request,$menu_id)
    {
        $query->whereIsActive(true)->whereMenuId($menu_id)
        ->whereHas('category', function ($query) use ($menu_id) {
            $query->whereMenuId($menu_id)
                ->whereIsActive(true);
        });

        if ($request->category) {
            $query->where('event_category_id', $request->category);
        }

        if ($request->keywords) {
            $keywords = $request->keywords;

            $query->whereHas('translations', function ($query) use ($keywords) {
                $query->whereLocale(locale())->where(function ($query) use ($keywords) {
                    $query->where('name', config('cms.sql.like'), '%' . $keywords . '%')
                        ->orWhere('description', config('cms.sql.like'), '%' . $keywords . '%');
                });
            });
        }

        if ($request->start_date) {
            $query->where('start_date', '>=', Carbon::parse($request->start_date)->format('Y-m-d'));
        }

        if ($request->end_date) {
            $query->where('end_date', '<=', Carbon::parse($request->end_date)->format('Y-m-d'));
        }

        return $query->orderBy('start_date')->paginate(config('cms-events.pagination'));
    }
}
