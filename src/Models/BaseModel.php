<?php

namespace Utichawa\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Utichawa\Events\Traits\ButtonsTrait;
use Illuminate\Database\Eloquent\Collection;

class BaseModel extends Model
{
    use ButtonsTrait;

    /**
     * Get Options for <select></select> for a given menu
     *
     * @param $query
     * @param int $menu_id
     * @return Collection
     */
    public function scopeGetSelectOptionsForMenu($query, int $menu_id): Collection
    {
        return $query->whereIsActive(true)->whereMenuId($menu_id)->get();
    }
}