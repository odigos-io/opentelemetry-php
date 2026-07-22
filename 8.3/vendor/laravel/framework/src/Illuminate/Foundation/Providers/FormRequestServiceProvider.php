<?php

namespace Odigos\Illuminate\Foundation\Providers;

use Odigos\Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Odigos\Illuminate\Foundation\Http\FormRequest;
use Odigos\Illuminate\Routing\Redirector;
use Odigos\Illuminate\Support\ServiceProvider;
class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });
        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $request = FormRequest::createFrom($app['request'], $request);
            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }
}
