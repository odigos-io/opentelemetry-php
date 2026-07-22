<?php

namespace Odigos\Illuminate\Foundation\Providers;

use Odigos\Illuminate\Contracts\Support\DeferrableProvider;
use Odigos\Illuminate\Database\MigrationServiceProvider;
use Odigos\Illuminate\Support\AggregateServiceProvider;
class ConsoleSupportServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var string[]
     */
    protected $providers = [ArtisanServiceProvider::class, MigrationServiceProvider::class, ComposerServiceProvider::class];
}
