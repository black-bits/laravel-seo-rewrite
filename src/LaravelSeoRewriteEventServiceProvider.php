<?php
namespace BlackBits\LaravelSeoRewrite;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LaravelSeoRewriteEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'BlackBits\LaravelSeoRewrite\Events\CreateSeoRewriteEvent' => [
            'BlackBits\LaravelSeoRewrite\Listeners\CreateSeoRewriteListener',
        ],
        'BlackBits\LaravelSeoRewrite\Events\DeleteSeoRewriteEvent' => [
            'BlackBits\LaravelSeoRewrite\Listeners\DeleteSeoRewriteListener',
        ],
        'BlackBits\LaravelSeoRewrite\Events\SavingSeoRewriteEvent' => [
            'BlackBits\LaravelSeoRewrite\Listeners\CheckForLoopSeoRewriteListener',
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
