<?php

namespace Illuminate\Foundation\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Odigos\PHPUnit\Framework\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
{
    use \Illuminate\Foundation\Testing\Concerns\InteractsWithContainer, \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests, \Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication, \Illuminate\Foundation\Testing\Concerns\InteractsWithConsole, \Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase, \Illuminate\Foundation\Testing\Concerns\InteractsWithDeprecationHandling, \Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling, \Illuminate\Foundation\Testing\Concerns\InteractsWithSession, \Illuminate\Foundation\Testing\Concerns\InteractsWithTime, \Illuminate\Foundation\Testing\Concerns\InteractsWithTestCaseLifecycle, \Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
    /**
     * The list of trait that this test uses, fetched recursively.
     *
     * @var array<class-string, int>
     */
    protected array $traitsUsedByTest;
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require Application::inferBasePath() . '/bootstrap/app.php';
        $this->traitsUsedByTest = array_flip(class_uses_recursive(static::class));
        if (isset(\Illuminate\Foundation\Testing\CachedState::$cachedConfig) && isset($this->traitsUsedByTest[\Illuminate\Foundation\Testing\WithCachedConfig::class])) {
            $this->markConfigCached($app);
        }
        if (isset(\Illuminate\Foundation\Testing\CachedState::$cachedRoutes) && isset($this->traitsUsedByTest[\Illuminate\Foundation\Testing\WithCachedRoutes::class])) {
            $app->booting(fn() => $this->markRoutesCached($app));
        }
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpTheTestEnvironment();
    }
    /**
     * Refresh the application instance.
     *
     * @return void
     */
    protected function refreshApplication()
    {
        $this->app = $this->createApplication();
    }
    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     *
     * @throws \Mockery\Exception\InvalidCountException
     */
    protected function tearDown(): void
    {
        $this->tearDownTheTestEnvironment();
    }
    /**
     * Clean up the testing environment before the next test case.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::tearDownAfterClassUsingTestCase();
    }
}
