<?php

namespace BlackBits\LaravelSeoRewrite\Listeners;

use BlackBits\LaravelSeoRewrite\Events\DeleteSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;

class DeleteSeoRewriteListener
{
    /**
     * Handle the event.
     *
     * @param DeleteSeoRewriteEvent $event
     *
     * @return void
     */
    public function handle(DeleteSeoRewriteEvent $event)
    {
        SeoRewrite::where('source', $event->source)->delete();
    }
}
