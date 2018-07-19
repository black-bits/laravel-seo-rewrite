<?php
namespace BlackBits\LaravelSeoRewrite\Listeners;

use BlackBits\LaravelSeoRewrite\Events\SavingSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;

class CheckForLoopSeoRewriteListener
{
    /**
     * Handle the event.
     *
     * @param  SavingSeoRewriteEvent  $event
     * @return void
     */
    public function handle(SavingSeoRewriteEvent $event)
    {
        $destination = $event->seoRewrite->destination;

        do {
            $tmp = SeoRewrite::where('source', $destination)->first();

            if ($tmp) {
                $destination = $tmp->destination;
            } else {
                $destination = false;
            }

            if ($destination == $event->seoRewrite->source) {
                throw new \Exception('SeoRewrite Loop Detected.');
            }

        } while ($destination);
    }
}
