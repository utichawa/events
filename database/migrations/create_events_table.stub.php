<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Utichawa\Events\Models\EventTranslation;
use Utichawa\Events\Models\Event;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if (!Schema::hasTable((new Event)->getTable())) {
            Schema::create((new Event)->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->boolean('is_active')->default(0);
                $table->dateTime('start_date')->nullable();
                $table->dateTime('end_date')->nullable();
                $table->integer('menu_id')->unsigned()->nullable();
                $table->foreign('menu_id')->references('id')->on('menus');
                $table->integer('event_category_id')->unsigned()->nullable();
                $table->foreign('event_category_id')->references('id')->on('event_categories');
                $table->integer('deleted_by')->nullable();
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable((new EventTranslation)->getTable())) {
            Schema::create((new EventTranslation)->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->integer('event_id')->unsigned();
                $table->foreign('event_id')->references('id')->on('events');
                $table->string('locale');
                $table->string('slug');
                $table->string('name');
                $table->text('description');
                $table->string('image')->nullable();
                $table->longText('content')->nullable();
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
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
        if (Schema::hasTable((new EventTranslation)->getTable())) {
            Schema::drop((new EventTranslation)->getTable());
        }
        if (Schema::hasTable((new Event)->getTable())) {
            Schema::drop((new Event)->getTable());
        }
    }
}
