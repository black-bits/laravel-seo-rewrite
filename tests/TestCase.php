<?php
namespace BlackBits\LaravelSeoRewrite\Tests;

use File;
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
            LaravelSeoRewriteServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->initializeDirectory($this->getTempDirectory());

        $app['config']->set('database.default', 'seoRewrites');
        $app['config']->set('database.connections.seoRewrites', [
            'driver' => 'sqlite',
            'database' => $this->getTempDirectory() . '/database.sqlite',
            'prefix' => ''
        ]);
    }

    protected function initializeDirectory(string $directory)
    {
        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }

        File::makeDirectory($directory);
    }

    public function setUpDatabase()
    {
        file_put_contents($this->getTempDirectory().'/database.sqlite', null);

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    protected function setUpRoutes()
    {
        Route::get('/', function () {
            return "Homepage";
        });

        Route::get('/hello/world', function () {
            return response()->json('OK', 200);
        })->name('hello.world');
    }

    protected function getTempDirectory()
    {
        return __DIR__.'/temp';
    }

    protected function purgeDatabase($directory)
    {
        File::deleteDirectory($directory);
    }
}