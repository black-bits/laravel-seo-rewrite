<?php
namespace BlackBits\LaravelSeoRewrite\Listeners;

use BlackBits\LaravelSeoRewrite\Events\CreateSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;

class CreateSeoRewriteListener
{
    /**
     * Handle the event.
     *
     * @param  CreateSeoRewriteEvent  $event
     * @return void
     */
    public function handle(CreateSeoRewriteEvent $event)
    {
        SeoRewrite::create([
            'source' => $event->source,
            'destination' => $event->destination,
            'type' => $event->type
        ]);
    }
}
