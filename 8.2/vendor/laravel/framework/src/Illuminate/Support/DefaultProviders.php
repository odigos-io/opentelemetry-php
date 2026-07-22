<?php

namespace Odigos\Illuminate\Support;

class DefaultProviders
{
    /**
     * The current providers.
     *
     * @var array
     */
    protected $providers;
    /**
     * Create a new default provider collection.
     */
    public function __construct(?array $providers = null)
    {
        $this->providers = $providers ?: [\Odigos\Illuminate\Auth\AuthServiceProvider::class, \Odigos\Illuminate\Broadcasting\BroadcastServiceProvider::class, \Odigos\Illuminate\Bus\BusServiceProvider::class, \Odigos\Illuminate\Cache\CacheServiceProvider::class, \Odigos\Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class, \Odigos\Illuminate\Concurrency\ConcurrencyServiceProvider::class, \Odigos\Illuminate\Cookie\CookieServiceProvider::class, \Odigos\Illuminate\Database\DatabaseServiceProvider::class, \Odigos\Illuminate\Encryption\EncryptionServiceProvider::class, \Odigos\Illuminate\Filesystem\FilesystemServiceProvider::class, \Odigos\Illuminate\Foundation\Providers\FoundationServiceProvider::class, \Odigos\Illuminate\Hashing\HashServiceProvider::class, \Odigos\Illuminate\Mail\MailServiceProvider::class, \Odigos\Illuminate\Notifications\NotificationServiceProvider::class, \Odigos\Illuminate\Pagination\PaginationServiceProvider::class, \Odigos\Illuminate\Auth\Passwords\PasswordResetServiceProvider::class, \Odigos\Illuminate\Pipeline\PipelineServiceProvider::class, \Odigos\Illuminate\Queue\QueueServiceProvider::class, \Odigos\Illuminate\Redis\RedisServiceProvider::class, \Odigos\Illuminate\Session\SessionServiceProvider::class, \Odigos\Illuminate\Translation\TranslationServiceProvider::class, \Odigos\Illuminate\Validation\ValidationServiceProvider::class, \Odigos\Illuminate\View\ViewServiceProvider::class];
    }
    /**
     * Merge the given providers into the provider collection.
     *
     * @param  array  $providers
     * @return static
     */
    public function merge(array $providers)
    {
        $this->providers = array_merge($this->providers, $providers);
        return new static($this->providers);
    }
    /**
     * Replace the given providers with other providers.
     *
     * @param  array  $replacements
     * @return static
     */
    public function replace(array $replacements)
    {
        $current = new Collection($this->providers);
        foreach ($replacements as $from => $to) {
            $key = $current->search($from);
            $current = is_int($key) ? $current->replace([$key => $to]) : $current;
        }
        return new static($current->values()->toArray());
    }
    /**
     * Disable the given providers.
     *
     * @param  array  $providers
     * @return static
     */
    public function except(array $providers)
    {
        return new static((new Collection($this->providers))->reject(fn($p) => in_array($p, $providers))->values()->toArray());
    }
    /**
     * Convert the provider collection to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->providers;
    }
}
