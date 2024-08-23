<?php

namespace App\Providers;

use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(AbstractRequest::class, function ($request, $app) {
            $request = AbstractRequest::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }
}
