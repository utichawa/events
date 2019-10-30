<?php

namespace Utichawa\Events\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class EventTranslation extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'event_id',
        'locale',
        'slug',
        'name',
        'description',
        'image',
        'content',
        'meta_title',
        'meta_description',
    ];


    // belongsTo Relationships

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
