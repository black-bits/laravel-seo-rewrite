<?php

namespace BlackBits\LaravelSeoRewrite\Tests;

use BlackBits\LaravelSeoRewrite\LaravelSeoRewriteServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
        $this->setUpDatabase();
        $this->setUpRoutes();
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteServiceProvider::class,
            LaravelSeoRewriteServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'seoRewrites');
        $app['config']->set('database.connections.seoRewrites', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function setUpDatabase()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function setUpRoutes()
    {
        Route::get('/', function () {
            return 'Homepage';
        });

        Route::get('/hello/world', function () {
            return response()->json('OK', 200);
        })->name('hello.world');
    }
}
