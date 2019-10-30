<?php
namespace Utichawa\Events\Traits;

/**
 * Example for using this trait:
 * 1/ Add created_by column to the Model's table (In the database)
 * 2/ Add this trait to the Model
 * 3/ Everytime you add a record, the created_by column is filled with the user id
 **/

trait UpdaterTrait
{

    protected static function boot()
    {
        parent::boot();

        /*
         * During a model creation Eloquent will also update the updated_at field so
         * we need to have the updated_by field here as well
         * */
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id ?? null;
            $model->updated_by = auth()->user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id ?? null;
        });

        /*
         * Deleting a model is slightly different than creating or deleting. For
         * deletes we need to save the model first with the deleted_by field
         * */
        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id ?? null;
            $model->save();
        });
    }

    public function created_by_user()
    {
        return $this->belongsTo('App\Models\Cms\User', 'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo('App\Models\Cms\User', 'updated_by');
    }

    public function deleted_by_user()
    {
        return $this->belongsTo('App\Models\Cms\User', 'deleted_by');
    }
}
