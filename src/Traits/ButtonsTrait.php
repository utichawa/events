<?php
namespace Utichawa\Events\Traits;

    /**
     *
     *
     *
     *
     *  TODO: This is an experiment ... check if its useful ?
     *  Made helpers:
     *      edit_button($href)
     *      show_button($href)
     *      delete_button($href)
     *
     *  IMPORTANT: Check if attributes ($model->show_button ... ) are used before deleting
     *
     *
     *
     */


/**
 * Example for using this trait:
 * 1/ Add created_by column to the Model's table (In the database)
 * 2/ Add this trait to the Model
 * 3/ Everytime you add a record, the created_by column is filled with the user id
 **/

trait ButtonsTrait
{
    /**
     * This is going to be used to generate show/edit/delete buttons
     */
    // private $backRouteName; ! [Important: https://stackoverflow.com/questions/32571920/overriding-doctrine-trait-properties]


    /**
     * @return string
     */
    public function getShowButtonAttribute(): string
    {
        if ($this->buttonsRouteNamePrefix) {
            return '<a class="btn btn-default btn-xs""
                   href="' . route($this->buttonsRouteNamePrefix . '.show', $this->id) . '"><span
                            class="glyphicon glyphicon-eye-open"></span></a>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute(): string
    {
        if ($this->buttonsRouteNamePrefix) {
            return '<a class="btn btn-primary btn-xs""
                   href="' . route($this->buttonsRouteNamePrefix . '.edit', $this->id) . '">
                   <span class="glyphicon glyphicon-pencil" 
                         data-placement="top" data-toggle="tooltip" 
                         title="' . trans('og.button.edit') . '"></span></a>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute(): string
    {
        if ($this->buttonsRouteNamePrefix) {
            return '<form style="display:inline"
                      action="' . route($this->buttonsRouteNamePrefix .  '.destroy', $this->id) . '"
                      method="POST">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                        <span data-placement="top" data-toggle="tooltip" title="' . trans('og.button.delete') . '">
                            <button class="btn btn-danger btn-xs" type="submit"
                                    onclick="return confirm(\'' . trans('og.alert.confirm_deletion') . '\')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </span>
                </form>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getEnableButtonAttribute(): string
    {
        if ($this->buttonsRouteNamePrefix) {
            $btn = ($this->is_active)?'success':'default';
            return '<a class="btn btn-'. $btn .' btn-xs toggle-status" 
            data-href="" href="#?" id="'. $this->id .'" rel="activate"
            title="'. trans('og.button.enable') .'">
            <i class="fa fa-check"></i></a>';
        }
        return '';
    }
}
