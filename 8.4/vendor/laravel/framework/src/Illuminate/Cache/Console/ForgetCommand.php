<?php

namespace Odigos\Illuminate\Cache\Console;

use Odigos\Illuminate\Cache\CacheManager;
use Odigos\Illuminate\Console\Command;
use Odigos\Symfony\Component\Console\Attribute\AsCommand;
#[AsCommand(name: 'cache:forget')]
class ForgetCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'cache:forget {key : The key to remove} {store? : The store to remove the key from}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an item from the cache';
    /**
     * The cache manager instance.
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;
    /**
     * Create a new cache clear command instance.
     *
     * @param  \Illuminate\Cache\CacheManager  $cache
     */
    public function __construct(CacheManager $cache)
    {
        parent::__construct();
        $this->cache = $cache;
    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->cache->store($this->argument('store'))->forget($this->argument('key'));
        $this->components->info('The [' . $this->argument('key') . '] key has been removed from the cache.');
    }
}
