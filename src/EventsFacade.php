<?php

namespace Utichawa\Events;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Utichawa\Events\Skeleton\SkeletonClass
 */
class EventsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'events';
    }
}
