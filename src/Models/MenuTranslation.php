<?php

namespace Utichawa\Events\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MenuTranslation extends BaseModel
{
    use LogsActivity, SoftDeletes;

    protected static $logFillable = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'menu_id',
        'locale',
        'label',
        'slug',
        'meta_title',
        'meta_description',
        'content',
    ];

    // belongsTo Relationships

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function menu_module()
    {

    }
}
