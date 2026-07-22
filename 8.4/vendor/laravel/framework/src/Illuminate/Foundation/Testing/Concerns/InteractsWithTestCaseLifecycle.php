<?php

namespace Odigos\Illuminate\Foundation\Testing\Concerns;

use Odigos\Carbon\CarbonImmutable;
use Odigos\Illuminate\Console\Application as Artisan;
use Odigos\Illuminate\Cookie\Middleware\EncryptCookies;
use Odigos\Illuminate\Database\Eloquent\Factories\Factory;
use Odigos\Illuminate\Database\Eloquent\Model;
use Odigos\Illuminate\Database\Migrations\Migrator;
use Odigos\Illuminate\Foundation\Bootstrap\HandleExceptions;
use Odigos\Illuminate\Foundation\Bootstrap\RegisterProviders;
use Odigos\Illuminate\Foundation\Console\AboutCommand;
use Odigos\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Odigos\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Odigos\Illuminate\Foundation\Http\Middleware\TrimStrings;
use Odigos\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Odigos\Illuminate\Foundation\Testing\DatabaseMigrations;
use Odigos\Illuminate\Foundation\Testing\DatabaseTransactions;
use Odigos\Illuminate\Foundation\Testing\DatabaseTruncation;
use Odigos\Illuminate\Foundation\Testing\RefreshDatabase;
use Odigos\Illuminate\Foundation\Testing\WithFaker;
use Odigos\Illuminate\Foundation\Testing\WithoutMiddleware;
use Odigos\Illuminate\Http\Client\Response;
use Odigos\Illuminate\Http\Middleware\HandleCors;
use Odigos\Illuminate\Http\Middleware\TrustHosts;
use Odigos\Illuminate\Http\Middleware\TrustProxies;
use Odigos\Illuminate\Http\Resources\Json\JsonResource;
use Odigos\Illuminate\Http\Resources\JsonApi\JsonApiResource;
use Odigos\Illuminate\Mail\Markdown;
use Odigos\Illuminate\Queue\Console\WorkCommand;
use Odigos\Illuminate\Queue\Queue;
use Odigos\Illuminate\Support\Carbon;
use Odigos\Illuminate\Support\EncodedHtmlString;
use Odigos\Illuminate\Support\Facades\Facade;
use Odigos\Illuminate\Support\Facades\ParallelTesting;
use Odigos\Illuminate\Support\Once;
use Odigos\Illuminate\Support\Sleep;
use Odigos\Illuminate\Support\Str;
use Odigos\Illuminate\Validation\Validator;
use Odigos\Illuminate\View\Component;
use Odigos\Mockery;
use Odigos\Mockery\Exception\InvalidCountException;
use Odigos\PHPUnit\Metadata\Annotation\Parser\Registry as PHPUnitRegistry;
use Throwable;
trait InteractsWithTestCaseLifecycle
{
    /**
     * The Illuminate application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;
    /**
     * The callbacks that should be run after the application is created.
     *
     * @var array
     */
    protected $afterApplicationCreatedCallbacks = [];
    /**
     * The callbacks that should be run before the application is destroyed.
     *
     * @var array
     */
    protected $beforeApplicationDestroyedCallbacks = [];
    /**
     * The exception thrown while running an application destruction callback.
     *
     * @var \Throwable
     */
    protected $callbackException;
    /**
     * Indicates if we have made it through the base setUp function.
     *
     * @var bool
     */
    protected $setUpHasRun = \false;
    /**
     * Setup the test environment.
     *
     * @internal
     *
     * @return void
     */
    protected function setUpTheTestEnvironment(): void
    {
        Facade::clearResolvedInstances();
        if (!$this->app) {
            $this->refreshApplication();
            ParallelTesting::callSetUpTestCaseCallbacks($this);
        }
        $this->setUpTraits();
        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            $callback();
        }
        Model::setEventDispatcher($this->app['events']);
        $this->setUpHasRun = \true;
    }
    /**
     * Clean up the testing environment before the next test.
     *
     * @internal
     *
     * @return void
     */
    protected function tearDownTheTestEnvironment(): void
    {
        if ($this->app) {
            $this->callBeforeApplicationDestroyedCallbacks();
            ParallelTesting::callTearDownTestCaseCallbacks($this);
            $this->app->flush();
            $this->app = null;
        }
        $this->setUpHasRun = \false;
        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }
        if (property_exists($this, 'defaultHeaders')) {
            $this->defaultHeaders = [];
        }
        if (class_exists('Odigos\Mockery')) {
            if ($container = Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }
            try {
                Mockery::close();
            } catch (InvalidCountException $e) {
                if (!Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                    throw $e;
                }
            }
        }
        if (class_exists(Carbon::class)) {
            Carbon::setTestNow();
        }
        if (class_exists(CarbonImmutable::class)) {
            CarbonImmutable::setTestNow();
        }
        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
        if (property_exists($this, 'originalExceptionHandler')) {
            $this->originalExceptionHandler = null;
        }
        if (property_exists($this, 'originalDeprecationHandler')) {
            $this->originalDeprecationHandler = null;
        }
        AboutCommand::flushState();
        Artisan::forgetBootstrappers();
        Component::flushCache();
        Component::forgetComponentsResolver();
        Component::forgetFactory();
        ConvertEmptyStringsToNull::flushState();
        Factory::flushState();
        EncodedHtmlString::flushState();
        EncryptCookies::flushState();
        HandleCors::flushState();
        HandleExceptions::flushState($this);
        JsonApiResource::flushState();
        JsonResource::flushState();
        Markdown::flushState();
        Migrator::withoutMigrations([]);
        Once::flush();
        PreventRequestsDuringMaintenance::flushState();
        Queue::createPayloadUsing(null);
        RegisterProviders::flushState();
        Response::flushState();
        Sleep::fake(\false);
        TrimStrings::flushState();
        TrustProxies::flushState();
        TrustHosts::flushState();
        ValidateCsrfToken::flushState();
        Validator::flushState();
        WorkCommand::flushState();
        if ($this->callbackException) {
            throw $this->callbackException;
        }
    }
    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = $this->traitsUsedByTest ?? array_flip(class_uses_recursive(static::class));
        if (isset($uses[RefreshDatabase::class])) {
            $this->refreshDatabase();
        }
        if (isset($uses[DatabaseMigrations::class])) {
            $this->runDatabaseMigrations();
        }
        if (isset($uses[DatabaseTruncation::class])) {
            $this->truncateDatabaseTables();
        }
        if (isset($uses[DatabaseTransactions::class])) {
            $this->beginDatabaseTransaction();
        }
        if (isset($uses[WithoutMiddleware::class])) {
            $this->disableMiddlewareForAllTests();
        }
        if (isset($uses[WithFaker::class])) {
            $this->setUpFaker();
        }
        foreach ($uses as $trait) {
            if (method_exists($this, $method = 'setUp' . class_basename($trait))) {
                $this->{$method}();
            }
            if (method_exists($this, $method = 'tearDown' . class_basename($trait))) {
                $this->beforeApplicationDestroyed(fn() => $this->{$method}());
            }
        }
        return $uses;
    }
    /**
     * Clean up the testing environment before the next test case.
     *
     * @internal
     *
     * @return void
     */
    public static function tearDownAfterClassUsingTestCase()
    {
        if (class_exists(PHPUnitRegistry::class)) {
            (function () {
                $this->classDocBlocks = [];
                $this->methodDocBlocks = [];
            })->call(PHPUnitRegistry::getInstance());
        }
    }
    /**
     * Register a callback to be run after the application is created.
     *
     * @param  callable  $callback
     * @return void
     */
    public function afterApplicationCreated(callable $callback)
    {
        $this->afterApplicationCreatedCallbacks[] = $callback;
        if ($this->setUpHasRun) {
            $callback();
        }
    }
    /**
     * Register a callback to be run before the application is destroyed.
     *
     * @param  callable  $callback
     * @return void
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeApplicationDestroyedCallbacks[] = $callback;
    }
    /**
     * Execute the application's pre-destruction callbacks.
     *
     * @return void
     */
    protected function callBeforeApplicationDestroyedCallbacks()
    {
        foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
            try {
                $callback();
            } catch (Throwable $e) {
                if (!$this->callbackException) {
                    $this->callbackException = $e;
                }
            }
        }
    }
}
