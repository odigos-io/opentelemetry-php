<?php

namespace Odigos\Illuminate\Foundation\Bootstrap;

use Odigos\Illuminate\Contracts\Foundation\Application;
use Odigos\Illuminate\Foundation\AliasLoader;
use Odigos\Illuminate\Foundation\PackageManifest;
use Odigos\Illuminate\Support\Facades\Facade;
class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);
        AliasLoader::getInstance(array_merge($app->make('config')->get('app.aliases', []), $app->make(PackageManifest::class)->aliases()))->register();
    }
}
