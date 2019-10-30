<?php

namespace Utichawa\Events\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MenuTranslation extends BaseModel
{
    use SoftDeletes;

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
