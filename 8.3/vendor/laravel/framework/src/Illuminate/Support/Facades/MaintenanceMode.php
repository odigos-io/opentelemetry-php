<?php

namespace Illuminate\Support\Facades;

use Illuminate\Foundation\MaintenanceModeManager;
class MaintenanceMode extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MaintenanceModeManager::class;
    }
}
