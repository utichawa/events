<?php

namespace Utichawa\Events\Http\Controllers;

use Utichawa\Events\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMenuIdOrFail(Request $request)
    {
        if ($request->menu_id) {

            // Check if the menu exists or fail
            if (! Menu::find($request->menu_id)) {
                abort(404);
            }

            return $request->menu_id;
        }

        abort(404);
    }

    public function toggleStatus(Request $request)
    {
        if ($request->ajax() && isset($this->mainModel)) {
            if ($request->id) {
                $model = $this->mainModel;
                $menu            = $model::find($request->id);
                $menu->is_active = ($menu->is_active) ? 0 : 1;
                $menu->save();
            }

            cache()->clear();

            return response()->json(['status' => 'success', 'is_active' => $menu->is_active]);
        }

        logger('Error:', ['Location' => 'App\Http\Controllers\Controller::toggleStatus()']);
    }
}
