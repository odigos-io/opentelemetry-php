<?php

namespace Odigos\Illuminate\Foundation\Console;

use Odigos\Illuminate\Console\Command;
use Odigos\Illuminate\Foundation\PackageManifest;
use Odigos\Illuminate\Support\Collection;
use Odigos\Symfony\Component\Console\Attribute\AsCommand;
#[AsCommand(name: 'package:discover')]
class PackageDiscoverCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'package:discover';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the cached package manifest';
    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Foundation\PackageManifest  $manifest
     * @return void
     */
    public function handle(PackageManifest $manifest)
    {
        $this->components->info('Discovering packages');
        $manifest->build();
        (new Collection($manifest->manifest))->keys()->each(fn($description) => $this->components->task($description))->whenNotEmpty(fn() => $this->newLine());
    }
}
