<?php

namespace Utichawa\Events\Models;

use Utichawa\Events\Traits\UpdaterTrait;
use Utichawa\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class EventCategory extends BaseModel
{
    use SoftDeletes, Translatable, UpdaterTrait, CascadeSoftDeletes;

    protected $cascadeDeletes = ['translations'];

    protected $buttonsRouteNamePrefix = 'back.event_categories';

    public $translatedAttributes = [
        'slug',
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'menu_id',
        'is_active',
        'order',
    ];

    // belongsTo Relationships

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // hasMany Relationships

    public function event_category_translations()
    {
        return $this->hasMany(EventCategoryTranslation::class, 'event_category_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'event_category_id');
    }
}
