<?php
namespace BlackBits\LaravelSeoRewrite;

use BlackBits\LaravelSeoRewrite\Middleware\LaravelSeoRewrites;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

class LaravelSeoRewriteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(LaravelSeoRewriteEventServiceProvider::class);

        // register middleware in $routeMiddleware
        Route::aliasMiddleware('seoRewrites', LaravelSeoRewrites::class);
        resolve(Kernel::class)->pushMiddleware(LaravelSeoRewrites::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}