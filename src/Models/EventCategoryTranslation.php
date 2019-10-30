<?php

namespace Utichawa\Events\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategoryTranslation extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'event_category_id',
        'locale',
        'slug',
        'name',
        'description',
    ];

    // belongsTo Relationships

    public function event_category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
