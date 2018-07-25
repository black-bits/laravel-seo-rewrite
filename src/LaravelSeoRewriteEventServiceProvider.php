<?php

namespace BlackBits\LaravelSeoRewrite;

use BlackBits\LaravelSeoRewrite\Events\CreateSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Events\DeleteSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Events\SavingSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Listeners\CheckForLoopSeoRewriteListener;
use BlackBits\LaravelSeoRewrite\Listeners\CreateSeoRewriteListener;
use BlackBits\LaravelSeoRewrite\Listeners\DeleteSeoRewriteListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LaravelSeoRewriteEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DeleteSeoRewriteEvent::class => [
            DeleteSeoRewriteListener::class,
        ],
        CreateSeoRewriteEvent::class => [
            CreateSeoRewriteListener::class,
        ],
        SavingSeoRewriteEvent::class => [
            CheckForLoopSeoRewriteListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
