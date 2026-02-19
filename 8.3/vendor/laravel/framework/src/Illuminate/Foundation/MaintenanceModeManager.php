<?php

namespace Illuminate\Foundation;

use Illuminate\Support\Manager;
class MaintenanceModeManager extends Manager
{
    /**
     * Create an instance of the file based maintenance driver.
     *
     * @return \Illuminate\Foundation\FileBasedMaintenanceMode
     */
    protected function createFileDriver(): \Illuminate\Foundation\FileBasedMaintenanceMode
    {
        return new \Illuminate\Foundation\FileBasedMaintenanceMode();
    }
    /**
     * Create an instance of the cache based maintenance driver.
     *
     * @return \Illuminate\Foundation\CacheBasedMaintenanceMode
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createCacheDriver(): \Illuminate\Foundation\CacheBasedMaintenanceMode
    {
        return new \Illuminate\Foundation\CacheBasedMaintenanceMode($this->container->make('cache'), $this->config->get('app.maintenance.store') ?: $this->config->get('cache.default'), 'illuminate:foundation:down');
    }
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('app.maintenance.driver', 'file');
    }
}
