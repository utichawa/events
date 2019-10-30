<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Utichawa\Events\Models\EventCategoryTranslation;
use Utichawa\Events\Models\EventCategory;

class CreateEventCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if (!Schema::hasTable((new EventCategory)->getTable())) {
            Schema::create((new EventCategory)->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->integer('menu_id')->unsigned()->nullable();
                $table->foreign('menu_id')->references('id')->on('menus');
                $table->boolean('is_active')->default(0);
                $table->integer('order')->nullable();
                $table->integer('deleted_by')->nullable();
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable((new EventCategoryTranslation)->getTable())) {
            Schema::create((new EventCategoryTranslation)->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->integer('event_category_id')->unsigned();
                $table->foreign('event_category_id')->references('id')->on('event_categories');
                $table->string('locale');
                $table->string('slug');
                $table->string('name');
                $table->text('description')->nullable();
                $table->unique(['slug', 'locale', 'deleted_at']);
                //$table->integer('deleted_by')->nullable();
                //$table->integer('created_by')->nullable();
                //$table->integer('updated_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        if (Schema::hasTable((new EventCategoryTranslation)->getTable())) {
            Schema::drop((new EventCategoryTranslation)->getTable());
        }
        if (Schema::hasTable((new EventCategory)->getTable())) {
            Schema::drop((new EventCategory)->getTable());
        }
    }
}
