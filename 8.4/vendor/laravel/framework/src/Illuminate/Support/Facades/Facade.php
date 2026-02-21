<?php

namespace Illuminate\Support\Facades;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Collection;
use Illuminate\Support\Js;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;
use Illuminate\Support\Uri;
use Odigos\Mockery;
use Odigos\Mockery\LegacyMockInterface;
use RuntimeException;
abstract class Facade
{
    /**
     * The application instance being facaded.
     *
     * @var \Illuminate\Contracts\Foundation\Application|null
     */
    protected static $app;
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;
    /**
     * Indicates if the resolved instance should be cached.
     *
     * @var bool
     */
    protected static $cached = \true;
    /**
     * Run a Closure when the facade has been resolved.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function resolved(Closure $callback)
    {
        $accessor = static::getFacadeAccessor();
        if (static::$app->resolved($accessor) === \true) {
            $callback(static::getFacadeRoot(), static::$app);
        }
        static::$app->afterResolving($accessor, function ($service, $app) use ($callback) {
            $callback($service, $app);
        });
    }
    /**
     * Convert the facade into a Mockery spy.
     *
     * @return \Mockery\MockInterface
     */
    public static function spy()
    {
        if (!static::isMock()) {
            $class = static::getMockableClass();
            return tap($class ? Mockery::spy($class) : Mockery::spy(), function ($spy) {
                static::swap($spy);
            });
        }
    }
    /**
     * Initiate a partial mock on the facade.
     *
     * @return \Mockery\MockInterface
     */
    public static function partialMock()
    {
        $name = static::getFacadeAccessor();
        $mock = static::isMock() ? static::$resolvedInstance[$name] : static::createFreshMockInstance();
        return $mock->makePartial();
    }
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return \Mockery\Expectation
     */
    public static function shouldReceive()
    {
        $name = static::getFacadeAccessor();
        $mock = static::isMock() ? static::$resolvedInstance[$name] : static::createFreshMockInstance();
        return $mock->shouldReceive(...func_get_args());
    }
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return \Mockery\Expectation
     */
    public static function expects()
    {
        $name = static::getFacadeAccessor();
        $mock = static::isMock() ? static::$resolvedInstance[$name] : static::createFreshMockInstance();
        return $mock->expects(...func_get_args());
    }
    /**
     * Create a fresh mock instance for the given class.
     *
     * @return \Mockery\MockInterface
     */
    protected static function createFreshMockInstance()
    {
        return tap(static::createMock(), function ($mock) {
            static::swap($mock);
            $mock->shouldAllowMockingProtectedMethods();
        });
    }
    /**
     * Create a fresh mock instance for the given class.
     *
     * @return \Mockery\MockInterface
     */
    protected static function createMock()
    {
        $class = static::getMockableClass();
        return $class ? Mockery::mock($class) : Mockery::mock();
    }
    /**
     * Determines whether a mock is set as the instance of the facade.
     *
     * @return bool
     */
    protected static function isMock()
    {
        $name = static::getFacadeAccessor();
        return isset(static::$resolvedInstance[$name]) && static::$resolvedInstance[$name] instanceof LegacyMockInterface;
    }
    /**
     * Get the mockable class for the bound instance.
     *
     * @return string|null
     */
    protected static function getMockableClass()
    {
        if ($root = static::getFacadeRoot()) {
            return get_class($root);
        }
    }
    /**
     * Hotswap the underlying instance behind the facade.
     *
     * @param  mixed  $instance
     * @return void
     */
    public static function swap($instance)
    {
        static::$resolvedInstance[static::getFacadeAccessor()] = $instance;
        if (isset(static::$app)) {
            static::$app->instance(static::getFacadeAccessor(), $instance);
        }
    }
    /**
     * Determines whether a "fake" has been set as the facade instance.
     *
     * @return bool
     */
    public static function isFake()
    {
        $name = static::getFacadeAccessor();
        return isset(static::$resolvedInstance[$name]) && static::$resolvedInstance[$name] instanceof Fake;
    }
    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }
    /**
     * Resolve the facade root instance from the container.
     *
     * @param  string  $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        if (static::$app) {
            if (static::$cached) {
                return static::$resolvedInstance[$name] = static::$app[$name];
            }
            return static::$app[$name];
        }
    }
    /**
     * Clear a resolved facade instance.
     *
     * @param  ?string  $name
     * @return void
     */
    public static function clearResolvedInstance($name = null)
    {
        unset(static::$resolvedInstance[$name ?? static::getFacadeAccessor()]);
    }
    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }
    /**
     * Get the application default aliases.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function defaultAliases()
    {
        return new Collection(['App' => \Illuminate\Support\Facades\App::class, 'Arr' => Arr::class, 'Artisan' => \Illuminate\Support\Facades\Artisan::class, 'Auth' => \Illuminate\Support\Facades\Auth::class, 'Benchmark' => Benchmark::class, 'Blade' => \Illuminate\Support\Facades\Blade::class, 'Broadcast' => \Illuminate\Support\Facades\Broadcast::class, 'Bus' => \Illuminate\Support\Facades\Bus::class, 'Cache' => \Illuminate\Support\Facades\Cache::class, 'Concurrency' => \Illuminate\Support\Facades\Concurrency::class, 'Config' => \Illuminate\Support\Facades\Config::class, 'Context' => \Illuminate\Support\Facades\Context::class, 'Cookie' => \Illuminate\Support\Facades\Cookie::class, 'Crypt' => \Illuminate\Support\Facades\Crypt::class, 'Date' => \Illuminate\Support\Facades\Date::class, 'DB' => \Illuminate\Support\Facades\DB::class, 'Eloquent' => Model::class, 'Event' => \Illuminate\Support\Facades\Event::class, 'File' => \Illuminate\Support\Facades\File::class, 'Gate' => \Illuminate\Support\Facades\Gate::class, 'Hash' => \Illuminate\Support\Facades\Hash::class, 'Http' => \Illuminate\Support\Facades\Http::class, 'Js' => Js::class, 'Lang' => \Illuminate\Support\Facades\Lang::class, 'Log' => \Illuminate\Support\Facades\Log::class, 'Mail' => \Illuminate\Support\Facades\Mail::class, 'Notification' => \Illuminate\Support\Facades\Notification::class, 'Number' => Number::class, 'Password' => \Illuminate\Support\Facades\Password::class, 'Process' => \Illuminate\Support\Facades\Process::class, 'Queue' => \Illuminate\Support\Facades\Queue::class, 'RateLimiter' => \Illuminate\Support\Facades\RateLimiter::class, 'Redirect' => \Illuminate\Support\Facades\Redirect::class, 'Request' => \Illuminate\Support\Facades\Request::class, 'Response' => \Illuminate\Support\Facades\Response::class, 'Route' => \Illuminate\Support\Facades\Route::class, 'Schedule' => \Illuminate\Support\Facades\Schedule::class, 'Schema' => \Illuminate\Support\Facades\Schema::class, 'Session' => \Illuminate\Support\Facades\Session::class, 'Storage' => \Illuminate\Support\Facades\Storage::class, 'Str' => Str::class, 'Uri' => Uri::class, 'URL' => \Illuminate\Support\Facades\URL::class, 'Validator' => \Illuminate\Support\Facades\Validator::class, 'View' => \Illuminate\Support\Facades\View::class, 'Vite' => \Illuminate\Support\Facades\Vite::class]);
    }
    /**
     * Get the application instance behind the facade.
     *
     * @return \Illuminate\Contracts\Foundation\Application|null
     */
    public static function getFacadeApplication()
    {
        return static::$app;
    }
    /**
     * Set the application instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application|null  $app
     * @return void
     */
    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }
    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }
        return $instance->{$method}(...$args);
    }
}
